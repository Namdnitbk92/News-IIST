<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // abort(500);    
        $news = \App\News::where('user_id', \Auth::user()->id)->orderBy('created_at', 'desc')->paginate(5);
        $titlePage = trans('app.news_list');
        $quantity = count($news);

        $counties = \App\County::all();
        $guilds = \App\Guild::all();
        $cities = \App\City::all();

        // $formQuickCreateNew = $this->genrenateFormQuickCreate();

        return view('news.newsList', compact('news', 'titlePage', 'quantity', 'counties', 'guilds', 'cities'));
    }

    public function getNewListAvaiableApprove()
    {
        $conds = [
            'user_id' => \Auth::user()->id,
            'status_id' => 1,
        ];

        $counties = \App\County::all();
        $guilds = \App\Guild::all();
        $cities = \App\City::all();

        $news = \App\News::where($conds)->where('publish_time', '>=', \Carbon\Carbon::now())->orderBy('created_at', 'desc')->paginate(5);
        
        $titlePage = trans('app.list_available_approve');
        $quantity = count($news);


        return view('news.newsList', compact('news', 'titlePage', 'quantity', 'counties', 'guilds', 'cities'));
    }

    private function genrenateFormQuickCreate()
    {
        return  $formQuickCreateNew = 
                '<form action="'.route('news.store').'" name="quickCreateNew" method="POST">'
                .csrf_field()
                .'<input type="hidden" name="quickCreate" value="yes"/>'
                .'<div class="form-group"><label class="col-sm-4">'.trans('app.title').'</label>'
                .'<div class="col-sm-8"><input type="text" name="title" class="form-control"/></div></div>'
                .'<div class="form-group"><label class="col-sm-4">'.trans('app.text').'</label>'
                .'<div class="col-sm-8"><textarea class="form-control" rows="5" name="audio_text" id="audio_text"></textarea></div></div>'
                .'</form>';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $counties = \App\County::all();
        $guilds = \App\Guild::all();
        $cities = \App\City::all();

        return view('news.create_news', compact('counties', 'guilds', 'cities'));
    }

    public function quickCreateNew($request)
    {
        try
        {
            \DB::beginTransaction();
            $new = \App\News::create(
                array_merge(
                    [
                        'title' => $request->get('title'),
                        'audio_text' => $request->get('audio_text'),
                    ],
                    [
                        'publish_time' => \Carbon\Carbon::now(),
                        'status_id' => 1,
                        'user_id' => \Auth::user()->id,
                    ]
                )
            );
        }
        catch(Exception $e)
        {
            \DB::rollBack();

            return redirect(route('news.create'))->with('error', $e->getMessage());
        }

        \DB::commit();

        return redirect(route('news.show', ['id' => $new->id]))
                ->with('status', trans('app.notification.create_success')); 
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewsRequest $request)
    {
        try
        {
            $isQuickCreate = $request->has('quickCreate');
            if($isQuickCreate)
            {
                $this->validate($request, $request->getQuickRules());

                return $this->quickCreateNew($request);
            }

            $this->validate($request, $request->getRules($request));

            $file = $request->file('audio-file');
            $path = "";

            if ($file !== null)
            {
                try
                {
                    $mimeType = $file->getMimeType();
                    if ($mimeType === 'text/plain')
                    {
                        $result = file_exists($file) ? file_get_contents($file) : '';

                    }
                    else
                    {
                        ini_set('max_execution_time', 6000);
                        $result = \Cloudder::uploadVideo($file)->getResult();
                    }
                    if (!is_string($result))
                        $path = array_key_exists('url', $result) ? $result['url'] : $result['secure_url'];
                    else
                        $path = '';
                }
                catch(Exception $up)
                {
                    return redirect(route('news.create'))->with('status', $up->getMessage()); 
                }
            }

            $attachFile = $request->file('attach-file');

            $attach_path = "";
            if ($attachFile !== null)
            {
                try
                {
                    ini_set('max_execution_time', 6000);
                    $result = \Cloudder::upload($attachFile)->getResult();

                    if (!is_string($result))
                        $attach_path = array_key_exists('url', $result) ? $result['url'] : $result['secure_url'];
                    else
                        $attach_path = '';
                }
                catch(Exception $up)
                {
                    return redirect(route('news.create'))->with('status', $up->getMessage()); 
                }
            }
            
            if (($path !== "" && !is_null($path)) || ($request->get('file_type') === 'text'))
            {
                try
                {
                    \DB::beginTransaction();
                    $type = $request->get('type');
                    $type = empty($type) ? \Auth::user()->belong_to_place : $type;
                    $place_data = [
                        'type' => $type,
                    ];
                    if ($type === 'county')
                    {
                        $place_data['original_place_id'] = !empty($request->get('county')) ? $request->get('county') : \Auth::user()->original_place_id;
                    }
                    else if ($type === 'guild')
                    {
                        $place_data['original_place_id'] = !empty($request->get('guild')) ? $request->get('guild') : \Auth::user()->original_place_id;
                    }
                    else 
                    {
                        $place_data['original_place_id'] = !empty($request->get('city')) ? $request->get('city') : \Auth::user()->original_place_id;
                    }
                    $publishTime = date("Y-m-d H:i:s", strtotime($request->get('publish_time'))) ?? Carbon::now();


                    $audio_text = $request->get('audio_text');
                    $place = \App\Places::create($place_data);
                    $new = \App\News::create(
                        array_merge(
                            $request->except(['publish_time', 'audio_text']), 
                            [
                                'status_id' => 1,
                                'audio_path' => $path, 
                                'place_id' => $place->id,
                                'publish_time' => $publishTime,
                                'audio_text' => $audio_text,
                                'attach_path_file' => $attach_path,
                            ]
                    ));
                }
                catch(Exception $ec)
                {
                    \DB::rollBack();
                    $isFailed = true;
                }

                if (!isset($isFailed))
                {
                    \DB::commit();
                }
                else
                {
                    return redirect(route('news.create'))->with('status', 'Xảy ra lỗi khi thêm mới'.$ec->getMessage())->withInput(); 
                }
                
            }
        }
        catch(Exception $e)
        {
            throw new Exception('Xảy ra lỗi khi thêm mới : '.$e->getMessage());
        }

        return redirect(route('news.index'))
                ->with('status', trans('app.notification.create_success'))->withInput(); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $new = \App\News::find($id);
        $user = $new ? \App\User::find($new->user_id) : null;
        $place = $new ? \App\Places::where('place_id', $new->place_id)->first() : null;
       

        $titlePage = trans('app.detail_information');

        if ($place)
        {
            switch ($place->type) {
                case 'city':
                    $original_place = \App\City::find($place->original_place_id);
                    $address = $original_place ? $original_place->name : '';
                    break;
                
                case 'county':
                    $original_place = \App\County::find($place->original_place_id);
                    if ($original_place)
                    {
                        $address = $original_place->name .' - '. $original_place->city()->first()->name;
                    }
                    break; 

                case 'guild':
                    $original_place = \App\Guild::find($place->original_place_id);
                    if ($original_place)
                    {
                        $address = $original_place->name .' - '. $original_place->county()->first()->name .' - ' . $original_place->county()->first()->city()->first()->name;
                    }
                    break;   

                default:
                    $address = '';
                    break;
            }
        }


        return view('news.show', compact('new', 'user', 'place', 'address', 'titlePage'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $new = \App\News::find($id);
        $counties = \App\County::all();
        $guilds = \App\Guild::all();
        $cities = \App\City::all();
        
        return view('news.edit', compact('new', 'cities', 'guilds', 'counties'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(NewsRequest $request, $id)
    {
        try
        {
            $this->validate($request, $request->getRules($request));

            $file = $request->file('audio-file');
            
            $path = "";
            if ($file !== null)
            {
                try
                {
                    $mimeType = $file->getMimeType();
                    if ($mimeType === 'text/plain')
                    {
                        $result = file_exists($file) ? file_get_contents($file) : '';
                    }
                    else
                    {
                        $result = \Cloudder::uploadVideo($file)->getResult();
                    }
                    if (!is_string($result))
                        $path = array_key_exists('url', $result) ? $result['url'] : $result['secure_url'];
                    else
                        $path = '';
                }
                catch(Exception $up)
                {
                    return redirect(route('news.create'))->with('status', $up->getMessage())->withInput(); 
                }
            }

            $attachFile = $request->file('attach-file');
            $attach_path = "";
            if ($attachFile !== null)
            {
                try
                {
                    
                    ini_set('max_execution_time', 6000);
                    $result = \Cloudder::upload($attachFile)->getResult();

                    if (!is_string($result))
                        $attach_path = array_key_exists('url', $result) ? $result['url'] : $result['secure_url'];
                    else
                        $attach_path = '';
                }
                catch(Exception $up)
                {
                    return redirect(route('news.create'))->with('status', $up->getMessage())->withInput(); 
                }
            }
            
            try
            {
                \DB::beginTransaction();
                $new = \App\News::find($id);
                $type = $request->get('type');
                $type = empty($type) ? \Auth::user()->belong_to_place : $type;
                $place_data = [
                    'type' => $type,
                ];
                if ($type === 'county')
                {
                    $place_data['original_place_id'] = !empty($request->get('county')) ? $request->get('county') : \Auth::user()->original_place_id;
                }
                else if ($type === 'guild')
                {
                    $place_data['original_place_id'] = !empty($request->get('guild')) ? $request->get('guild') : \Auth::user()->original_place_id;
                }
                else 
                {
                    $place_data['original_place_id'] = !empty($request->get('city')) ? $request->get('city') : \Auth::user()->original_place_id;
                }
                $publish_time = $request->get('publish_time');
                $audio_text = $request->get('audio_text');
                $place = \DB::table('places')->where('place_id', $new->place_id);

                if (!is_null($place->first()))
                {
                    $place->update($place_data);
                    $placeId = $place->first()->place_id;
                }
                else
                {
                    $place = \App\Places::create($place_data);
                    $placeId = $place->id;
                }

                $new->update(
                    array_merge(empty($publish_time) ? $request->except('publish_time') : $request->all(), 
                    [
                        'audio_path' => empty($path) ? $new->audio_path : $path, 
                        'place_id' => $placeId,
                        'audio_text' => $audio_text,
                        'attach_path_file' => $attach_path,
                    ]
                ));
            }
            catch(Exception $ec)
            {
                \DB::rollBack();
                $isFailed = true;
            }

            if (!isset($isFailed))
            {
                \DB::commit();
            }
            else
            {
                return redirect(route('news.create'))
                    ->with('status', 'Xảy ra lỗi khi cập nhật'.$ec->getMessage())->withInput(); 
            }
        }
        catch(Exception $e)
        {
            throw new Exception('Xảy ra lỗi khi cập nhật: '.$e->getMessage());
        }

        return redirect()->route('news.edit', ['id' => $new->id])
                    ->with('status', trans('app.notification.edit_success'))->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {
            \DB::beginTransaction();

            $new = \App\News::find($id);
            $place = \App\Places::where('place_id', $new->place_id);

            if ($place)
            {
                $place->delete();
            }

            $new->delete();
        }
        catch(Exception $ec)
        {
            \DB::rollBack();

            return redirect(route('news.index'))
                ->with('error', 'Xảy ra lỗi khi xóa dữ liệu : ' . $ec->getMessage());

        }
         
        \DB::commit();

        return redirect(route('news.index'))
                ->with('status', trans('app.notification.delete_success'));
    }

    public function getGuildList(Request $request)
    {
        if ($request->ajax())
        {
            $countyId = $request->get('county_id');

            if ($countyId !== null)
            {
                $guilds = \App\Guild::where('county_id', $countyId)->get();
            }
        }

        return response()->json([
            'status' => 200,
            'guilds' => $guilds ?: [],
        ]);
    }


    public function approveNew(Request $request)
    {
        if ($request->ajax())
        {
            $newId = $request->get('newId');

            if ($newId !== null)
            {
                try
                {
                    \DB::beginTransaction();
                    $new = \App\News::find($newId);

                    if ($new->hasApprove())
                    {
                        $new->status_id = config('attribute.status.approved');
                        $new->update();
                    }
                    else
                    {
                        return response()->json([
                            'status' => 500,
                            'message' => trans('app.require_new_publish_time'),
                        ]);
                    }
                }
                catch(Exception $e)
                {
                    \DB::rollBack();
                    return response()->json([
                        'status' => 500,
                        'message' => 'has errors appeared cause' . $e->getMessage(),
                    ]);
                }
                \DB::commit();
            }
        }

        return response()->json([
            'status' => 200,
            'status_text' => $new->status()->first()->description,
            'message' => trans('app.new_approved'),
        ]);
    }

    public function search(Request $request)
    {
        $news = \App\News::search($request->search)->orderBy('created_at', 'desc')->paginate(10);
        $quantity = count($news);

        $counties = \App\County::all();
        $guilds = \App\Guild::all();
        $cities = \App\City::all();

        $titlePage = trans('app.news_list');
        $formQuickCreateNew = $this->genrenateFormQuickCreate();

        return view('news.newsList', compact('news', 'quantity', 'titlePage', 'counties', 'guilds', 'cities'));
    }

    public function copyNew(Request $request)
    {
        $new = \App\News::find($request->get('id'));
        if (!empty($new))
        {
            try
            {
                \DB::beginTransaction();
                $copyNew = $new->replicate();
                $copyNew->save();
                $msg = "Copy nội dung thông báo thành công , mã thông báo mới  :" . $copyNew->id;
            }
            catch(Exception $e)
            {
                \DB::rollBack();
                $msg = "Copy nội dung thông báo không thành công  :" . $e->getMessage();

                return redirect()->back()->with('status', $msg);
            }

            \DB::commit();
        }
        else
        {
            return redirect()->back()->with('error', 'The new can not copied');
        }

        return redirect(route('news.show', ['id' => $copyNew->id]))
                ->with('status', $msg ?? '');
    }

    public function noticeApprove(Request $request)
    {
        $new = \App\News::find($request->get('id'));
        if (!empty($new))
        {
            try
            {
                \DB::beginTransaction();
                $msg = "Tạo yêu cầu phê duyệt nội dung thành công, xin hãy đợi kết quả phê duyệt từ người quản lý!!";
                $manager = $new->getManager();
                if (is_null($manager))
                {
                    return redirect()->back()->with('error', 'Bạn cần cập nhật thêm thông tin về vị trí mà nội dung đưa ra thông báo tới (Quận , phường , huyện nào...)) để xác nhận người quản lý!');
                }

                $new->approved_by = $manager;
                $new->status_id = config('attribute.status.inprogress');
                $new->save();
            }
            catch(Exception $e)
            {
                \DB::rollBack();
                $msg = "Tạo yêu cầu lỗi :" . $e->getMessage();

                return redirect()->back()->with('status', $msg);
            }

            \DB::commit();
        }
        else
        {
            return redirect()->back()->with('error', 'Mã nội dung thông báo không được trống');
        }

        return redirect()->back()
                ->with('status', $msg ?? '');
    }

    public function getRequireToApproveNewsListByCreater()
    {
        $user = \Auth::user();
        $titlePage = trans('app.list_required_approve');
        if ($user->isCreater())
        {
            $conds = [
                'user_id' => $user->id,
                'status_id' => config('attribute.status.inprogress'),
            ];

            $where = \App\News::where($conds)
                ->where('approved_by', '<>', 'NULL');
        }
        else
        {
            $conds = [
                'approved_by' => $user->id,
                'status_id' => config('attribute.status.inprogress'),
            ];

            $where = \App\News::where($conds);
        }
        $news = $where->where('publish_time', '>=', \Carbon\Carbon::now())->paginate(10);

        return view('news.newsListByRequiredToApprove', compact('news', 'titlePage'));
    }

    public function deleteApproved(Request $request)
    {
        $new = \App\News::find($request->get('id'));
        if (!empty($new))
        {
            try
            {
                \DB::beginTransaction();
                $msg = "Từ chối yêu cầu phê duyệt cho nội dung thành công!";
                $new->approved_by = null;
                $new->status_id = config('attribute.status.canceled');
                $new->reason = $request->get('reason');
                $new->save();
            }
            catch(Exception $e)
            {
                \DB::rollBack();
                $msg = "Xuất hiện lỗi khi từ chối:" . $e->getMessage();

                return redirect()->back()->with('status', $msg);
            }

            \DB::commit();
        }
        else
        {
            return redirect()->back()->with('error', 'Mã nội dung thông báo không được trống');
        }

        return redirect(route('news.show', ['id' => $new->id]))
                ->with('status', $msg ?? '');
    }

    public function getNewDetail(Request $request)
    {
        if ($request->ajax())
        {
            $new = \App\News::find($request->get('newId'));

            return response()->json([
                'errorCode' => 0,
                'new' => json_encode($new) ?: [],
            ]);
        }
    }

    public function updateNew(Request $request)
    {dd($request->all());
        return $this->update($request, $request->get('newId'));
    }
}

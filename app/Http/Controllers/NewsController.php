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
        $news = \App\News::paginate(5);
        $titlePage = 'News List';
        $quantity = count($news);

        return view('news.newsList', compact('news', 'titlePage', 'quantity'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $counties = \App\County::all();

        return view('news.create_news', compact('counties'));
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
            $audioFile = $request->file('audio-file');
            $path = "";
            if ($audioFile !== null)
            {
                try
                {
                    $result = \Cloudder::uploadVideo($audioFile)->getResult();
                    $path = array_key_exists('url', $result) ? $result['url'] : $result['secure_url'];
                }
                catch(Exception $up)
                {
                    return redirect(route('news.create'))->with('status', $up->getMessage()); 
                }
            }
            else
            {
                // $audioText = $request->get('audio-text');
                // if ($audioText !== null && $audioText !== "")
                // {
                //     $googleProvider = new \duncan3dc\Speaker\Providers\GoogleProvider;
                //     $textToSpeech = new \duncan3dc\Speaker\TextToSpeech($audioText, $googleProvider);
                //     file_put_contents("/tmp/hello.mp3", $textToSpeech->getAudioData());
                //     return redirect()->back();
                // }
            }
            
            if ($path !== "" && !is_null($path))
            {
                try
                {
                    \DB::beginTransaction();
                    $type = $request->get('type');
                    $place_data = [
                        'type' => $request->get('type'),
                    ];

                    if ($type === 'county')
                    {
                        $place_data['original_place_id'] = $request->get('county');
                    }
                    else if ($type === 'guild')
                    {
                        $place_data['original_place_id'] = $request->get('guild');
                    }
                    else 
                    {
                        $place_data['original_place_id'] = $request->get('city');
                    }
                    $publishTime = date( "Y-m-d H:i:s", strtotime($request->get('publish_time'))) ?? Carbon::now();
                    
                    $place = \App\Places::create($place_data);
                    $new = \App\News::create(
                        array_merge(
                            $request->except('publish_time'), 
                            [
                                'status_id' => 1,
                                'audio_path' => $path, 
                                'place_id' => $place->id,
                                'publish_time' => $publishTime,
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
                    return redirect(route('news.create'))->with('status', 'Create a new has occurred failed cause'.$ec->getMessage()); 
                }
                
            }
        }
        catch(Exception $e)
        {
            throw new Exception('create new is failed, cause : '.$e->getMessage());
        }

        return redirect(route('news.show', ['id' => $new->id]))
                ->with('status', 'Create a new is successfully'); 
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
        $titlePage = 'Detail Information of The New ID ' . $new->id;

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
        
        return view('news.create_news', compact('new'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try
        {
            $audioFile = $request->file('audio-file');
            $path = "";
            if ($audioFile !== null)
            {
                try
                {
                    $result = \Cloudder::uploadVideo($audioFile)->getResult();
                    $path = array_key_exists('url', $result) ? $result['url'] : $result['secure_url'];
                }
                catch(Exception $up)
                {
                    return redirect(route('news.create'))->with('status', $up->getMessage()); 
                }
            }

            try
            {
                \DB::beginTransaction();
                $new = \App\News::find($id);
                $type = $request->get('type');
                $place_data = [
                    'type' => $request->get('type'),
                ];

                if ($type === 'county')
                {
                    $place_data['original_place_id'] = $request->get('county');
                }
                else if ($type === 'guild')
                {
                    $place_data['original_place_id'] = $request->get('guild');
                }
                else 
                {
                    $place_data['original_place_id'] = $request->get('city');
                }
                $publish_time = $request->get('publish_time');
                $place = \App\Places::where('place_id', $new->place_id);
                $place->update($place_data);
                $new->update(
                    array_merge(empty($publish_time) ? $request->except('publish_time') : $request->all(), 
                    [
                        'status_id' => 1,
                        'audio_path' => empty($path) ? $new->audio_path : $path, 
                        'place_id' => $place->first()->place_id
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
                    ->with('status', 'Update a new has occurred failed cause'.$ec->getMessage()); 
            }
        }
        catch(Exception $e)
        {
            throw new Exception('update new is failed, cause : '.$e->getMessage());
        }

        return redirect()->route('news.edit', ['id' => $new->id])
                    ->with('status', 'Update a new is successfully'); 
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
                ->with('error', 'Delete this new has errors cause : ' . $ec->getMessage());

        }
         
        \DB::commit();

        return redirect(route('news.index'))
                ->with('status', 'Delete this new successfully!!');
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
                            'message' => 'To approve this new is failed cause its publish time is invalid (required greater of equal published current time )!!',
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
            'message' => 'This new was approved!!',
        ]);
    }

    public function search(Request $request)
    {
        $news = \App\News::search($request->search)->paginate(10);
        $quantity = count($news);
        $titlePage = 'News List';

        return view('news.newsList', compact('news', 'quantity', 'titlePage'));
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
                $msg = "Copy this new is successfully, the newly new has newId :" . $copyNew->id;
            }
            catch(Exception $e)
            {
                \DB::rollBack();
                $msg = "Copy this new has occurred errors cause :" . $e->getMessage();

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
                $msg = "Makes approve notification for this new is successfully, please waiting for approved by superior!!";
                $new->approved_by = $news->getManager();
                $new->status_id = config('attribute.status.inprogress');
                $new->save();
            }
            catch(Exception $e)
            {
                \DB::rollBack();
                $msg = "Make approve notification for this new has occurred errors cause :" . $e->getMessage();

                return redirect()->back()->with('status', $msg);
            }

            \DB::commit();
        }
        else
        {
            return redirect()->back()->with('error', 'The newId can not empty');
        }

        return redirect(route('news.show', ['id' => $copyNew->id]))
                ->with('status', $msg ?? '');
    }

    public function getRequireToApproveNewsListByCreater()
    {
        $user = \Auth::user();
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

        return view('news.newsListByRequiredToApprove', compact('news'));
    }
}

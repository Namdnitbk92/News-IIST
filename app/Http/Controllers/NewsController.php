<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news = \App\News::paginate(10);

        return view('news.newsList', compact('news'));
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
    public function store(Request $request)
    {
        try
        {
            $audioFile = \Request::file('audio-file');
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

                    $place = \App\Places::create($place_data);
                    \App\News::create(array_merge($request->all(), ['status_id' => 1,'audio_path' => $path, 'place_id' => $place->id]));
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

        return redirect(route('news.create'))->with('status', 'Create a new is successfully'); 
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
                        $address = $original_place->name .' - '. $original_place->county()->first()->name .' - ' . $original_place->county()->city()->first()->name;
                    }
                    break;   

                default:
                    $address = '';
                    break;
            }
        }


        return view('news.show', compact('new', 'user', 'place', 'address'));
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
            $audioFile = \Request::file('audio-file');
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

                $place = \App\Places::where('place_id', $new->place_id)->get();
                $place->save($place_data);
                \App\News::save(array_merge($request->all(), ['status_id' => 1,'audio_path' => $path, 'place_id' => $place->id]));
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
                return redirect(route('news.create'))->with('status', 'Update a new has occurred failed cause'.$ec->getMessage()); 
            }
        }
        catch(Exception $e)
        {
            throw new Exception('update new is failed, cause : '.$e->getMessage());
        }

        return redirect(route('news.create'))->with('status', 'Update a new is successfully'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
}

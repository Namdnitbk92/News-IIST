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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('news.create_news');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // try
        // {
        //     DB::beginTransaction();
        //     News::create($request->all());
        // }
        // catch(Exception $e)
        // {
        //     DB::rollBack();
        //     $isFailed = true;
        // }

        // if (!isset($isFailed))
        // {
        //     $audioFile = \Request::file('audio-file');
        //     $result = \Cloudder::uploadVideo($audioFile)->getResult();
        //     $path = array_key_exists('url', $result) ? $result['url'] : $result['secure_url'];

        //     if ($path !== "" && !is_null($path))
        //     {
        //         DB::commit();

        //          return redirect(route('news.create'))->with('status', 'Create a new has errors occurreds'); 
        //     } 
        //     else 
        //     {
        //         DB::rollBack();
        //     }
        // }

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
}

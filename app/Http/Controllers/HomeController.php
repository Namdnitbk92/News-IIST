<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news = \App\News::all();
        $newsOne = [];
        $newsSecond = [];
        $plot = count($news) / 2;

        for ($i = $plot ;$i >= 0 ;$i-- )
        {
            array_push($newsOne, $news[$i]);

            if (count($news) - 1 >= $plot && $plot > $i)
            {
                array_push($newsSecond, $news[$plot]);
                $plot++;
            }
        }

        return view('home',compact('newsOne', 'newsSecond'));
    }
}

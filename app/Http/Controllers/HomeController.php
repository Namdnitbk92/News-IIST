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

    public function back() 
    {
        return redirect('/home');
    }

    function showLanguage(Request $request)
    {

        $languages = [
            ['id' => 'vi', 'name' => 'Vietnamese'],
            ['id' => 'en', 'name' => 'English'],
        ];

        if ($request->isMethod('POST'))
        {
            $locale = $request->has('language') ? $request->get('language') : 'en';
            if(in_array($locale, ['en', 'vi']))
            {
                \App::setLocale($locale);
                session()->put('current_locale', $locale);

                return redirect()->back()->with('status', 'Change language sucessfully');
            }
        }

        return view('language', compact('languages'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
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

        $request->session()->flash('showChannel', 'true');

        return view('home',compact('newsOne', 'newsSecond'));
    }

    public function getNotifications()
    {
        $news = \App\News::where([
            'approved_by' => \Auth::user()->id,
            'status_id' => config('attribute.status.inprogress')
        ])->where('publish_time', '>=', \Carbon\Carbon::now())->get();

        return response()->json([
            'totalNotifications' => count($news),
            'news' => $news,
        ]);
    }
}

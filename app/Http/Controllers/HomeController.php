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

    public function getPreview(Request $request)
    {
        $newId = $request->get('newId');
        if ($request->ajax() && !empty($newId))
        {
            $new = \App\News::find($newId);
            $user = $new ? \App\User::find($new->user_id) : null;
            $place = $new ? \App\Places::where('place_id', $new->place_id)->first() : null;
            $status = isset($new) && $new->status() ? $new->status()->first()->description ?? '' : '';
            $new = json_decode(json_encode($new));
            $new->status = $status;
            $new->place = $place->name ?? '';
            $new->username = $user->name ?? '';
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

                $new->address = $address ?? '';
            }

            return response()->json(['errorCode' => 0, 'new' => json_encode($new)]);
        }

        return response()->json(['errorCode' => 1, 'message' => 'Có lỗi khi xem trước nội dung, hãy xem lại sau!']);
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
        $news = \App\News::where('publish_time', '>=', \Carbon\Carbon::now())->orderBy('publish_time', 'ASC')->take(10)->get();

        $titlePage = 'Trang chủ';
        return view('home',compact('news', 'titlePage'));
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

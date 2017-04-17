<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cityList = \App\City::paginate(5);
        $titlePage = 'City List';

        return view('city.cityList', compact('cityList', 'titlePage'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $titlePage = 'Create a city';
        $users = \App\User::where('role_id', config('attribute.role.approver'))->get();

        return view('city.create',compact('titlePage', 'users'));
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
            \DB::beginTransaction();
            $guild = \App\City::create($request->all());
        }
        catch(Exception $e)
        {
            \DB::rollBack();

            return redirect()->back()->with('error', 'Create City has failed cause !!' . $e->getMessage());
        }

        \DB::commit();

        return redirect()->back()->with('status', 'Create City successfully!!');
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
        $city = \App\City::find($id);
        $users = \App\User::where('role_id', config('attribute.role.approver'))->get();

        if (empty($city))
        {
            return redirect()->back()->with('error', 'The city with id ' . $id . ' is not exists on system..!');
        }

        $titlePage = 'Edit city [' . $city->name . ']';

        return view('city.create', compact('city', 'titlePage', 'users'));
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
            \DB::beginTransaction();
            $city = \App\City::find($id);
            $city->update($request->all());
            $cityName = $city->name;
        }
        catch(Exception $e)
        {
            \DB::rollBack();

            return redirect()->back()->with('error', 'update city [' . $cityName . '] has failed cause !!' . $e->getMessage());
        }

        \DB::commit();

        return redirect()->back()->with('status', 'update city  [' . $cityName . ']  successfully!!');
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
            $city = \App\City::find($id);
            $cityName = $city->name;
            $city->delete();
        }
        catch(Exception $e)
        {
            \DB::rollBack();

            return redirect()->back()->with('error', 'Delete city [' . $cityName . '] has failed cause !!' . $e->getMessage());
        }

        \DB::commit();

        return redirect()->back()->with('status', 'Delete city  [' . $cityName . ']  successfully!!');
    }
}

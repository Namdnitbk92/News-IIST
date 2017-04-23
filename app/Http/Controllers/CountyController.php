<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CountyRequest;

class CountyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countyList = \App\County::orderBy('created_at', 'desc')->paginate(5);
        $titlePage = '';

        return view('county.countyList', compact('countyList', 'titlePage'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $titlePage = 'Create a county';
        $city = \App\City::all();
        $users = \App\User::where('role_id', config('attribute.role.approver'))->get();

        return view('county.create',compact('titlePage', 'city', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CountyRequest $request)
    {
        try
        {
            \DB::beginTransaction();
            $guild = \App\County::create($request->all());
        }
        catch(Exception $e)
        {
            \DB::rollBack();

            return redirect()->back()->with('error', 'Create county has failed cause !!' . $e->getMessage());
        }

        \DB::commit();

        return redirect()->back()->with('status', 'Create county successfully!!');
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
        $county = \App\County::find($id);
        $city = \App\City::all();
        $users = \App\User::where('role_id', config('attribute.role.approver'))->get();

        if (empty($county))
        {
            return redirect()->back()->with('error', 'The county with id' . $id . 'is not exists on system..!');
        }

        $titlePage = 'Edit County [' . $county->name . ']';

        return view('county.create', compact('county', 'titlePage', 'city', 'users'));
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
            $county = \App\County::find($id);
            $county->update($request->all());
            $CountyName = $county->name;
        }
        catch(Exception $e)
        {
            \DB::rollBack();

            return redirect()->back()->with('error', 'update county [ ' . $CountyName . ' ] has failed cause !!' . $e->getMessage());
        }

        \DB::commit();

        return redirect()->back()->with('status', 'update county  [' . $CountyName . ']  successfully!!');
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
            $county = \App\County::find($id);
            $countyName = $county->name;
            $county->delete();
        }
        catch(Exception $e)
        {
            \DB::rollBack();

            return redirect()->back()->with('error', 'Delete county [ ' . $countyName . ' ]has failed cause !!' . $e->getMessage());
        }

        \DB::commit();

        return redirect()->back()->with('status', 'Delete county  [ ' . $countyName . ' ] successfully!!');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuildController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $guildList = \App\Guild::paginate(5);
        $titlePage = 'Guild List';

        return view('guild.guildList', compact('guildList', 'titlePage'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
            $guild = \App\Guild::create($request->all());
        }
        catch(Exception $e)
        {
            \DB::rollBack();

            return redirect()->back()->with('error', 'Create guild has failed cause !!' . $e->getMessage());
        }

        \DB::commit();

        return redirect()->back()->with('status', 'Create guild successfully!!');
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
        $guild = \App\Guild::find($id);
        $county = \App\County::all();
        $users = \App\User::where('role_id', config('attribute.role.approver'))->get();

        if (empty($guild))
        {
            return redirect()->back()->with('error', 'The guild with id' . $id . 'is not exists on system..!');
        }

        $titlePage = 'Edit Guild ' . $guild->name;

        return view('guild.create', compact('guild', 'county', 'users', 'titlePage'));
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
            $guild = \App\Guild::find($id);
            $guild->update($request->all());
            $guildName = $guild->name;
        }
        catch(Exception $e)
        {
            \DB::rollBack();

            return redirect()->back()->with('error', 'update guild ' . $guildName . 'has failed cause !!' . $e->getMessage());
        }

        \DB::commit();

        return redirect()->back()->with('status', 'update guild  ' . $guildName . '  successfully!!');
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
            $guild = \App\Guild::find($id);
            $guildName = $guild->name;
            $guild->delete();
        }
        catch(Exception $e)
        {
            \DB::rollBack();

            return redirect()->back()->with('error', 'Delete guild ' . $guildName . 'has failed cause !!' . $e->getMessage());
        }

        \DB::commit();

        return redirect()->back()->with('status', 'Delete guild  ' . $guildName . '  successfully!!');
    }
}

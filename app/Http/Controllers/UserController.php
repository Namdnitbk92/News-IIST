<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UsersRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = \App\User::paginate(5);
        $titlePage = 'Users List';

        return view('users.users', compact('users', 'titlePage'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = \App\Role::all();
        $titlePage = 'Create new user';

        return view('users.create', compact('roles', 'titlePage'));
    }

    public function profile(Request $request)
    {
        $titlePage = 'Profile';
        $uid = $request->get('userId');
        $user = !empty($uid) ? \App\User::find($uid) : \Auth::user(); 
        
        return view('users.profile', compact('user', 'titlePage '));
    }


    public function search(Request $request)
    {
        $users = \App\User::search($request->search)->paginate(10);
        $quantity = count($users);
        $titlePage = 'Users List';

        return view('users.users', compact('users', 'quantity'));
    }

    public function editProfile()
    {
        $user = \Auth::user();

        return $this->edit($user->id);
    }

    public function passwordReset(Request $request, $token = null)
    {
        return view('auth.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsersRequest $request)
    {
        try
        {
            \DB::beginTransaction();
            $guild = \App\User::create(array_merge(
                $request->all(),
                [
                    'belong_to_place' => \Auth::user()->belong_to_place,
                    'original_place_id' => \Auth::user()->original_place_id,
                ]
            ));
        }
        catch(Exception $e)
        {
            \DB::rollBack();

            return redirect()->back()->with('error', 'Create user has failed cause !!' . $e->getMessage());
        }

        \DB::commit();

        return redirect()->back()->with('status', 'Create user successfully!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = \App\User::find($id);

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = \App\User::find($id);
        $roles = \App\Role::all(); 

        if (empty($user))
        {
            return redirect()->back()->with('error', 'The user with id' . $id . 'is not exists on system..!');
        }

        $titlePage = 'Edit User [' . $user->name . '] information';

        return view('users.create', compact('user', 'titlePage', 'roles'));
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
            $user = \App\User::find($id);
            $user->update($request->all());
        }
        catch(Exception $e)
        {
            \DB::rollBack();

            return redirect()->back()->with('error', 'update user has failed cause !!' . $e->getMessage());
        }

        \DB::commit();

        return redirect()->back()->with('status', 'update user successfully!!');
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
            $user = \App\User::find($id);
            $user->delete();
        }
        catch(Exception $e)
        {
            \DB::rollBack();

            return redirect()->back()->with('error', 'Delete user has failed cause !!' . $e->getMessage());
        }

        \DB::commit();

        return redirect()->back()->with('status', 'Delete user successfully!!');
    }
}

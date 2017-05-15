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
        // \App\User::create([
        //     'name' => 'adminTP',
        //     'api_token' => str_random(60),
        //     'email' => 'adminTP@test.com',
        //     'password' => bcrypt('123123'),
        //     'role_id' => 6,
        //     'original_place_id' => 1,
        //     'belong_to_place' => 'city',
        // ]);

        $roles = \App\Role::all();
        $places = \Auth::user()->getListPlaceByUser();
        $counties = $places['counties'];
        $guilds = $places['guilds'];
        $cities = $places['cities'];

        $original_place_id = \Auth::user()->original_place_id;
        $belong_to_place = \Auth::user()->belong_to_place;
        $conds = ['belong_to_place' => $belong_to_place, 'original_place_id' => $original_place_id];
        if ($belong_to_place === 'city')
        {
            $tableChild = 'county';
            $condsTemp = ['belong_to_place' => 'county', 'role_id' => 6];
        }
        else if($belong_to_place === 'county')
        {
            $tableChild = 'guild';
            $condsTemp = ['belong_to_place' => 'guild', 'role_id' => 6];
        }

        $users = \App\User::where($conds);

        if (!empty($condsTemp))
        {
            $users = $users->orWhere(function ($query) use ($condsTemp, $original_place_id, $tableChild) {
                $query->where($condsTemp)
                ->whereIn('original_place_id', function ($querySub) use ($original_place_id, $tableChild){
                    $querySub->select('id')
                    ->from($tableChild)
                    ->where(($tableChild == 'county' ? 'city_id' : 'county_id'), $original_place_id)
                    ->get();
                });
            });
        }

        $users = $users->orderBy('created_at', 'desc')->paginate(5);
        $titlePage = 'Danh sách người dùng';

        return view('users.users', compact('users', 'titlePage', 'roles', 'cities', 'guilds', 'counties'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = \App\Role::all();
        $places = \Auth::user()->getListPlaceByUser();
        $counties = $places['counties'];
        $guilds = $places['guilds'];
        $cities = $places['cities'];

        $titlePage = 'Tạo mới người dùng';
        return view('users.create', compact('roles', 'titlePage', 'cities', 'guilds', 'counties'));
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
        $roles = \App\Role::all();
        $places = \Auth::user()->getListPlaceByUser();
        $counties = $places['counties'];
        $guilds = $places['guilds'];
        $cities = $places['cities'];

        $searchValue = $request->search;
        $searchValue = !empty($searchValue) ? trim($searchValue) : '';
        $original_place_id = \Auth::user()->original_place_id;
        $belong_to_place = \Auth::user()->belong_to_place;
        $conds = ['belong_to_place' => $belong_to_place, 'original_place_id' => $original_place_id];

        if ($belong_to_place === 'city')
        {
            $tableChild = 'county';
            $condsTemp = ['belong_to_place' => 'county', 'role_id' => 6];
        }
        else if($belong_to_place === 'county')
        {
            $tableChild = 'guild';
            $condsTemp = ['belong_to_place' => 'guild', 'role_id' => 6];
        }

        // if (!empty($searchValue))
        // {
            $users = \App\User::where(function($query) use ($searchValue) {
                $query->where('name', 'like', '%' . $searchValue . '%')
                ->orWhere('email', 'like', '%' . $searchValue . '%');
            });
        // }

        $users = $users->where($conds);

        if (!empty($condsTemp))
        {
            $users = $users->orWhere(function ($query) use ($condsTemp, $original_place_id, $tableChild, $searchValue) {
                $query->where($condsTemp)
                ->whereIn('original_place_id', function ($querySub) use ($original_place_id, $tableChild){
                    $querySub->select('id')
                    ->from($tableChild)
                    ->where(($tableChild == 'county' ? 'city_id' : 'county_id'), $original_place_id)
                    ->get();
                });
            });
        }

        $users = $users->orderBy('created_at', 'desc')->paginate(5);

        $quantity = count($users);
        $titlePage = 'Danh sách người dùng';

        return view('users.users', compact('users', 'quantity', 'titlePage', 'roles', 'cities', 'guilds', 'counties'));
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
    public function store(Request $request)
    {
        try
        {
            $belong_to_place = \Auth::user()->belong_to_place;
            $original_place_id = \Auth::user()->original_place_id;
            \DB::beginTransaction();
            $pw = $request->get('password');
            $data = [];
            $data['role_id'] = $request->has('role_id') ? $request->get('role_id') : 6;
            if ($request->has('password'))
            {
                $data['password'] = bcrypt($pw);
            }

            foreach ($request->get('original_place_id') as $key => $value) {
                if (!empty($value))
                {
                    $data['original_place_id'] = $value;
                }
            }
            $data['belong_to_place'] = $request->get('place_type');
           
            $data = array_merge(
                $request->except('password'),
                $data
            );

            if($belong_to_place === 'guild')
            {
                $data['original_place_id'] = $original_place_id;
                $data['belong_to_place'] = $belong_to_place;
            }

            $data['api_token'] = str_random(60);

            $user = \App\User::create($data);
        }
        catch(Exception $e)
        {
            \DB::rollBack();

            return redirect()->back()->with('error', 'Tạo mới người dùng lỗi !!' . $e->getMessage())->withInput();
        }

        \DB::commit();

        return redirect(route('users.index'))->with('status', 'Tạo mới người dùng thành công!');
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
        $places = \Auth::user()->getListPlaceByUser();
        $counties = $places['counties'];
        $guilds = $places['guilds'];
        $cities = $places['cities'];

        if (empty($user))
        {
            return redirect()->back()->with('error', 'The user with id' . $id . 'is not exists on system..!');
        }

        $titlePage = 'Chỉnh sửa thông tin người dùng [' . $user->name . ']';

        return view('users.create', compact('user', 'titlePage', 'roles', 'counties', 'cities', 'guilds'));
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
            $belong_to_place = \Auth::user()->belong_to_place;
            $original_place_id = \Auth::user()->original_place_id;
            
            \DB::beginTransaction();
            $user = \App\User::find($id);
            $data = $request->all();
            if ($request->has('password'))
            {   
                $pw = $request->get('password');
                $data['password'] = bcrypt($pw);
            }

            $hasVal = false;
            foreach ($request->get('original_place_id') as $key => $value) {
                if (!empty($value))
                {
                    $data['original_place_id'] = $value;
                    $hasVal = true;
                    break;
                }
            }

            $data['belong_to_place'] = $request->get('place_type');

            if(!$hasVal)
            {
                $data['original_place_id'] = $original_place_id;
            }

            if(empty($data['belong_to_place']))
            {
                $data['belong_to_place'] = $belong_to_place;
            }

            $user->update($data);
        }
        catch(Exception $e)
        {
            \DB::rollBack();

            return redirect()->back()->with('error', 'update user has failed cause !!' . $e->getMessage());
        }

        \DB::commit();

        return redirect(route('users.index'))->with('status', 'Cập nhật thành công!');
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

        return redirect()->back()->with('status', 'Xóa thành công!');
    }

    public function getUserDetail(Request $request)
    {
        if ($request->ajax() && $request->has('userId'))
        {
            $user = \App\User::find($request->get('userId'));

            return response()->json([
                'errorCode' => 0,
                'user' => isset($user) ? json_encode($user) : [],
            ]);
        }

        return response()->json([
            'errorCode' => 0,
            'user' => [],
        ]);
    }

    public function updateUser(Request $request)
    {
        return $this->update($request, $request->get('userId'));
    }

}

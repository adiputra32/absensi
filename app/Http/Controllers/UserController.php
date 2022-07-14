<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\{UserUpdateRequest,UserAddRequest};
use Spatie\Permission\Models\Role;
use App;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize(User::class, 'index');
        if($request->ajax())
        {
            $users = new User;
            if(Auth::user()->username)
            {
                $users = $users->where('username', 'like', '%'.Auth::user()->username.'%');
            }
            $users = $users->paginate(config('stisla.perpage'))->appends(['username' => Auth::user()->username]);
            // return response()->json($users);
        }
        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('admin.users.create');
        return view('auth.register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserAddRequest $request)
    {
        // $user = User::create($request->all());
        // $role = Role::find($request->role);
        // if($role)
        // {
        //     $user->assignRole($role);
        // }
        // return response()->json($user);

        User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);

        return redirect()->back()->with(['info' => 'Register berhasil!']);
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
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        if(!App::environment('demo'))
        {
            $user->update($request->only([
                'name', 'email'
            ]));

            if($request->password)
            {
                $user->update(['password' => Hash::make($request->password)]);
            }

            if($request->role && $request->user()->can('edit-users') && !$user->isme)
            {
                $role = Role::find($request->role);
                if($role)
                {
                    $user->syncRoles([$role]);
                }
            }
        }

        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if(!App::environment('demo') && !$user->isme)
        {
            $user->delete();
        } else
        {
            return response()->json(['message' => 'User accounts cannot be deleted in demo mode.'], 400);
        }
    }

    public function roles()
    {
        return response()->json(Role::get());
    }

    public function login(){
        return view('auth.login');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller implements HasMiddleware
{

      public static  function middleware(): array
    {
        return [
            new Middleware('permission:view users', only: ['users.index']),
            new Middleware('permission:view users', only: ['users.edit']),
            // new Middleware('permission:view roles', only: ['create']),
            // new Middleware('permission:view roles', only: ['destroy'])
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('users.list', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::orderBy('name', 'ASC')->get();

        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'name' =>   'required|min:3',
            'email' =>  'required|unique:users:email',
            'password' =>   'required|min:5|same:confirm_password',
            'confirm_password' =>   'required|min:5',

        ]);

        if ($validator->fails()) {
            return redirect()->route('users.create')->withInput()->withErrors($validator);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->email = $request->email;
        $user->save();

        $user->syncRoles($request->role);

        return redirect()->route('users.index')->with('success', 'User Added SuccessFully.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findorfail($id);
        $roles = Role::orderBy('name', 'ASC')->get();

        $hasRoles = $user->roles->pluck('id');
        return view('users.edit', compact('user', 'roles', 'hasRoles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $user = User::findorfail($id);

        $validator = Validator::make($request->all(), [
            'name' =>   'required|min:3',
            'email' =>  'required|unique:users,email,' . $id . ',id'
        ]);

        if ($validator->fails()) {
            return redirect()->route('users.edit', $id)->withInput()->withErrors($validator);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        $user->syncRoles($request->role);

        return redirect()->route('users.index', $id)->with('success', 'User Updated SuccessFully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

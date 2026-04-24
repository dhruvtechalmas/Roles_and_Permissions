<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PermissionController extends Controller  implements HasMiddleware
{

    public static  function middleware(): array
    {
        return [
            new Middleware('permission:View permissions', only: ['index']),
            new Middleware('permission:Create permissions', only: ['create']),
            new Middleware('permission:Edit permissions', only: ['edit']),
            new Middleware('permission:Delete permissions', only: ['destroy']),
        ];
    }

    //Show permission page
    public function index()
    {
        $permissions = Permission::orderBy('created_at', 'DESC')->paginate(25);

        return view('permissions.list', compact('permissions'));
    }

    //Create permission page    
    public function create()
    {
        return view('permissions.create');
    }

    //inser a permission in db
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:permissions|min:3'
        ]);
        if ($validator->passes()) {
            Permission::create(['name' => $request->name]);
            return redirect()->route('permissions.index')->with('success', 'Permission Added Successfully');
        } else {

            return redirect()->route('permissions.create')->withInput()->withErrors($validator);
        }
    }


    //edit a permission in db
    public function edit(int $id)
    {

        $permission = Permission::findorfail($id);
        return view('permissions.edit', compact('permission'));
    }


    //update a permission 
    public function update(int $id, Request $request)
    {
        $permission = Permission::findorfail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|unique:permissions,name,' . $id . ',id'
        ]);
        if ($validator->passes()) {

            $permission->name = $request->name;
            $permission->save();

            return redirect()->route('permissions.index')->with('success', 'Permission Update Successfully');
        } else {

            return redirect()->route('permissions.edit', $id)->withInput()->withErrors($validator);
        }
    }

    //Destroy a permission 
    public function destroy(Request $request)
    {

        $id = $request->id;

        $permission = Permission::find($id);

        if ($permission == null) {

            session()->flash('error', 'Permission Not Found');
            return response()->json([
                'status' => false
            ]);
        }

        $permission->delete();

        session()->flash('success', 'Permission deleted successfully');
        return response()->json([
            'status' => true
        ]);
    }
}

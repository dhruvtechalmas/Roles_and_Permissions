<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;


class RoleController extends Controller  implements HasMiddleware
{

      public static  function middleware(): array
    {
        return [
            new Middleware('permission:view roles', only: ['roles.index']),
            new Middleware('permission:view roles', only: ['roles.edit']),
            new Middleware('permission:view roles', only: ['roles.create']),
            new Middleware('permission:view roles', only: ['roles.destroy'])
        ];
    }
    
    //show roles page
    public function index()
    {

        $roles = Role::orderBy('name', 'ASC')->paginate(25);
        return view('roles.list', compact('roles'));
    }

    //create roles page
    public function create()
    {

        $permissions = Permission::orderBy('name', 'ASC')->get();

        return view('roles.create', compact('permissions'));
    }


    //inset roles in db
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'name' => 'required|unique:roles|min:3'
        ]);

        if ($validator->passes()) {
            $role = Role::create(['name' => $request->name]);

            if (!empty($request->permission)) {
                foreach ($request->permission as $name) {
                    $role->givePermissionTo($name);
                    # code...
                }
                # code...
            }

            return redirect()->route('roles.index')->with('success', 'Role Added Successfully');
        } else {

            return redirect()->route('roles.create')->withInput()->withErrors($validator);
        }
    }


    public function edit(int $id)
    {

        $role = Role::findorfail($id);

        $haspermissions  = $role->permissions->pluck('name');
        $permissions = Permission::orderBy('name', 'ASC')->get();   


        return view('roles.edit', compact('haspermissions', 'permissions', 'role'));
    }

    public function update(int $id, Request $request){

        $role = Role::findorfail($id);

         $validator = Validator::make($request->all(), [

            'name' => 'required|unique:roles,name,'.$id.',id|min:3'
        ]);

        if ($validator->passes()) {
           $role->name = $request->name;
           $role->save();

            if (!empty($request->permission)) {
               $role->syncPermissions($request->permission);

             }else{
                $role->syncPermissions([]);
             }
               
            return redirect()->route('roles.index')->with('success', 'Role Update Successfully.');
    
        } else {
    
            return redirect()->route('roles.edit',$id)->withInput()->withErrors($validator);
        }
           
    }

    public function destroy(Request $request){

        $id = $request->id;

        $role = Role::find($id);

        if($role == null){
              session()->flash('error','Role not Found.');
            return response()->json([
                'status' => false
            ]);
        }

        $role->delete();
     
        session()->flash('success','Role Deleted SuccessFully.');

        return response()->json([
            'status' => true
        ]);

    }
}

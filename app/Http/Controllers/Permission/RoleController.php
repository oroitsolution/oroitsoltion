<?php

namespace App\Http\Controllers\Permission;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller implements HasMiddleware
{
    
    public static function  middleware():array
    {
        return [
            new Middleware('permission:view roles', only:['index']),
            new Middleware('permission:edit roles', only:['edit']),
            new Middleware('permission:create roles', only:['create']),
            new Middleware('permission:delete roles', only:['delete']),
        ];
    }


    public function index()
    {
        $role=Role::OrderBy('name','ASC')->paginate(5);
         return view('permissionrole.role.index',[
            'roles' => $role
         ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions=Permission::OrderBy('name','ASC')->get();
        return view('permissionrole.role.create',[
            'permissions' => $permissions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
     
        $validator = Validator::make($request->all(),[
            'name'=>'required|unique:roles|min:3'
        ]);

        if($validator->passes()){
            $role=Role::create(['name'=>$request->name]);

            if(!empty($request->permission)){
                foreach($request->permission as $name){
                    $role->givePermissionTo($name);
                }
            }
            return redirect()->route('roles.index')->with('success','Role Added Successfully');
        }else{
            return redirect()->route('roles.create')->withInput()->withErrors($validator);
        }
    }

    /**
     * Display the specified resource.
     */
  
    public function edit(string $id)
    {
        $role=Role::findOrFail($id);
        $haspermissions = $role->permissions->pluck('name');

        $permissions=Permission::OrderBy('name','ASC')->get();
       
        return view('permissionrole.role.edit',[
            'permissions'    => $permissions,
            'haspermissions' => $haspermissions,
            'role'           => $role
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request){
        $role=Role::findOrFail($id);
        
        $validator = Validator::make($request->all(),[
            'name'=>'required|unique:roles,name,'.$id.',id'
        ]);

        if($validator->passes()){
            $role->name = $request->name;
            $role->save();

            if(!empty($request->permission)){
                $role->syncPermissions($request->permission);
            }else{
                $role->syncPermissions([]);
            }
            return redirect()->route('roles.index')->with('success','Role Updated Successfully');
        }else{
            return redirect()->route('roles.edit')->withInput()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request){
       
        $id = $request->id;
        $role=Role::find($id);
        if($role == null){
            session()->flash('error','Role not found');
            return response()->json([
                'status'=>false
            ]);
        }
        $role->delete();
        session()->flash('error','Role Deleted Successfully');
            return response()->json([
                'status'=>true
            ]);
    }
}

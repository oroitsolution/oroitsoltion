<?php

namespace App\Http\Controllers\Permission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PermissionController extends Controller implements HasMiddleware
{

    public static function  middleware():array
    {
        return [
            new Middleware('permission:view permissions', only:['index']),
            new Middleware('permission:edit permissions', only:['edit']),
            new Middleware('permission:create permissions', only:['create']),
            new Middleware('permission:delete permissions', only:['delete']),
        ];
    }

    public function index(){
        $permissions=Permission::OrderBy('created_at','ASC')->paginate(25);
        return view('permissionrole.permission.index',[
            'permissions' => $permissions
        ]);
    }

    public function create(){
        return view('permissionrole.permission.create');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'required|unique:permissions|min:3'
        ]);

        if($validator->passes()){
            Permission::create(['name'=>$request->name]);
            return redirect()->route('permissions.index')->with('success','Permission Added Successfully');
        }else{
            return redirect()->route('permissions.create')->withInput()->withErrors($validator);
        }

    }

    public function edit($id){
        $permissions=Permission::findOrFail($id);
        return view('permissionrole.permission.edit',[
            'permission'=>$permissions
        ]);
    }

    public function update($id, Request $request){
        $permissions=Permission::findOrFail($id);

        $validator = Validator::make($request->all(),[
            'name'=>'required|min:3|unique:permissions,name,'.$id.',id'
        ]);

        if($validator->passes()){
            $permissions->name =$request->name;
            $permissions->save();
            return redirect()->route('permissions.index')->with('success','Permission Updated Successfully');
        }else{
            return redirect()->route('permissions.edit',$id)->withInput()->withErrors($validator);
        }
    }

    public function destroy(Request $request){
        
        $id = $request->id;
        $permissions=Permission::find($id);
        if($permissions == null){
            session()->flash('error','Permission not found');
            return response()->json([
                'status'=>false
            ]);
        }
        $permissions->delete();
        session()->flash('error','Permission Deleted Successfully');
            return response()->json([
                'status'=>true
            ]);
    }
}

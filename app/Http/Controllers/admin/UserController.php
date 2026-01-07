<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Auth;

class UserController extends Controller implements HasMiddleware
{

public static function  middleware():array
    {
        return [
            new Middleware('permission:view users', only:['index']),
            new Middleware('permission:edit users', only:['edit']),
            new Middleware('permission:create users', only:['create']),
            new Middleware('permission:delete users', only:['delete']),
        ];
    }

    public function enter($merchantId)
    {
       session(['superadmin_id' => Auth::id()]);

        $merchant = User::findOrFail($merchantId);

        Auth::login($merchant);
        return redirect()->route('user.dashboard')->with('success', 'You are now logged in as merchant.');
    }

    public function backToAdmin()
    {
        $superadminId = session('superadmin_id');

        if ($superadminId) {
            Auth::loginUsingId($superadminId);
            session()->forget('superadmin_id');
            return redirect()->route('superadmin.users.index')->with('success', 'Back as super admin');
        }

        return redirect('/')->with('error', 'No impersonation session found.');
    }

    public function index(){
        $user=User::where('role_id','!=','1')->latest()->paginate(10);
        
        return view('admin.user.index',[
            'users' => $user
        ]);
    }

    public function edit($id){
        $users=User::findOrFail($id);
        $role=Role::orderBy('name','ASC')->get();

        $hasrols=$users->roles->pluck('id');
        return view('admin.user.edit',[
            'user'    => $users,
            'roles'   => $role,
            'hasrols' => $hasrols
        ]);
    }

    public function update(Request $request, string $id){
       
        $user=User::findOrFail($id);
        $validator = Validator::make($request->all(),[
            'name'=>'required|min:3',
            'email'=>'required|email|unique:users,email,'.$id.',id',
        ]);

        if($validator->fails()){
            return redirect()->route('users.edit',$id)->withInput()->withErrors($validator);
        }

        $user->name= $request->name;
        $user->email= $request->email;
        $user->save();

        $user->syncRoles($request->role);
        return redirect()->route('users.index')->with('success','User Updated Successfully');
    }
}

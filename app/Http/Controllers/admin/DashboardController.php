<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class DashboardController extends Controller
{
    public function index(){
        return view('admin.dashboards');
    }


    public function contact(Request $request){
        $contact=DB::table('contacts') ->orderBy('id', 'desc')->paginate(10);
        return view('admin.contact.index',compact('contact'));
    }
}

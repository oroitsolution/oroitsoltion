<?php

namespace App\Http\Controllers\admin\fund;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FundRequest;
use App\Models\User;
use DB;

class FundRequestController extends Controller
{
    public function index(Request $request){
      $data= Fundrequest::leftJoin('users','users.id','fund_requests.user_id')->select('users.name','fund_requests.*')->get();
      return view('admin.fundrequest.index',compact('data'));
    }

    public function store(Request $request)
    {
       
         $oldamount =  User::where('id', $request->userid)->select('wallet_amount')->first();
        if ($request->value === 'success') 
            {
            User::where('id', $request->userid)->increment('wallet_amount', $request->amount);
            }

            DB::table('fund_requests')
                ->where('id', $request->id)
                ->update([
                    'status' => $request->value,
                    'oldamount'    => $oldamount->wallet_amount,
                    'updated_at' => now(),
                ]);

            return redirect()->back()->with('success', 'Fund request processed successfully.');
    }
    
}

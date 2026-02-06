<?php

namespace App\Http\Controllers\admin\fund;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FundRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\User;


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

    // -----------------------------------------------------------------//
    // ------------------User Fund Request ----------------------------//

    public function fundadd_show(Request $request){
       $fundRequests = FundRequest::where('user_id', auth()->id())
                        ->latest()
                        ->paginate(10);
      return view('user.fundrequest.index',compact('fundRequests'));
    }

    public function addfund_proceed(Request $request){
        
        $validator = Validator::make($request->all(), [
            'pamount'      => 'required|numeric|min:1',
            'paymntmode'  => 'required',
            'paymntdate'  => 'required|date',
            'ifsc'       => 'required',
            'bankname'    => 'required|not_in:0',
            'acnumber'    => 'required|not_in:0',
            'utr'         => 'nullable|string',
            'remark'      => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
         $user = Auth::user();

        FundRequest::create([
            'user_id'         => auth()->id(),   
            'deposit_amount'  => $request->pamount,
            'payment_method'  => $request->paymntmode,
            'paymentdate'    => $request->paymntdate,
            'ifsc'           => $request->ifsc,
            'bank_name'      => $request->bankname,
            'account_detail' => $request->acnumber,
            'utr'            => $request->utr,
            'remark'         => $request->remark,
            'oldamount'      => $user->wallet_amount,
            'status'         => 'pending',
        ]);

        return response()->json([
            'message' => 'Fund request submitted successfully'
        ]);
    }

    
}

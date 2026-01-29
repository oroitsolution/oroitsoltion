<?php

namespace App\Http\Controllers\admin\Payout;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use DB;

class PayoutController extends Controller implements HasMiddleware
{

    public static function  middleware():array
    {
        return [
            new Middleware('permission:view payout', only:['index']),
            new Middleware('permission:refund payout payment', only:['refund']),
            
        ];
    }


     public function index(Request $request){
        
        $query = DB::table('payout_payment')
            ->leftJoin('users', 'users.id', '=', 'payout_payment.merchant_id')
            ->select('payout_payment.*', 'users.name as merchantname');

        // 🔍 Key Based Search
        if ($request->key && $request->search_data) {
            if (in_array($request->key, ['trx_id','utr', 'account_number'])) {
                $query->where("payout_payment.{$request->key}", 'LIKE', '%' . $request->search_data . '%');
            }
        }
        // 📅 Date Based Filter (only when key not selected)
        else {
            if ($request->start_date) {
                $query->where('payout_payment.created_at', '>=', $request->start_date . ' 00:00:00');
            }

            if ($request->end_date) {
                $query->where('payout_payment.created_at', '<=', $request->end_date . ' 23:59:59');
            }
        }

        // Status Filter
        if ($request->status && in_array($request->status, ['success', 'pending', 'fail'])) {
            $query->where('payout_payment.status', $request->status);
        }

        $data = $query->orderBy('payout_payment.id', 'DESC')->paginate(20);
        return view('admin.payout.index',compact('data'));
    }

     public function refund(Request $request){
        $query = DB::table('payout_payment')
        ->leftJoin('users', 'users.id', '=', 'payout_payment.user_id')
        ->whereIn('payout_payment.status', ['FAILED', 'Failure'])
        ->select('payout_payment.*', 'users.name as merchantname');

        $data = $query->orderBy('payout_payment.id', 'DESC')->get();
         return view('admin.payout.refund',compact('data'));
     }
}

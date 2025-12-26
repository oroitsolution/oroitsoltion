<?php

namespace App\Http\Controllers\admin\payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Charge;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use DB;

class AdminPaymentController extends Controller 
{
    // public static function  middleware():array
    // {
    //     return [
    //         new Middleware('permission:view charges', only:['index']),
    //         new Middleware('permission:edit charges', only:['edit']),
           
    //     ];
    // }
    
    public function index(Request $request)
    {
        $query = DB::table('payment')
            ->leftJoin('users', 'users.id', '=', 'payment.user_id')
            ->select('payment.*', 'users.name as merchantname');

        // 🔍 Key Based Search
        if ($request->key && $request->search_data) {
            if (in_array($request->key, ['trxid','utr', 'account_number'])) {
                $query->where("payment.{$request->key}", 'LIKE', '%' . $request->search_data . '%');
            }
        }
        // 📅 Date Based Filter (only when key not selected)
        else {
            if ($request->start_date) {
                $query->where('payment.created_at', '>=', $request->start_date . ' 00:00:00');
            }

            if ($request->end_date) {
                $query->where('payment.created_at', '<=', $request->end_date . ' 23:59:59');
            }
        }

        // Status Filter
        if ($request->status && in_array($request->status, ['Pending', 'COMPLETED', 'Refunded'])) {
            $query->where('payment.status', $request->status);
        }

        $data = $query->orderBy('payment.id', 'DESC')->paginate(20);

        return view('admin.payment.payment', compact('data'));
    }


    
}

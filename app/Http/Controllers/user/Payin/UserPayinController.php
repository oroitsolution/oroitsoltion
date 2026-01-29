<?php

namespace App\Http\Controllers\user\Payin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserPayinController extends Controller
{
   public function userpayindata(Request $request){
    $query = DB::table('payins')
            ->where('user_id', Auth::id());

        if ($request->key && $request->search_data) {

        if (in_array($request->key, ['systemgenerateid','utr', 'order_id'])) {
            $query->where("payins.{$request->key}", 'LIKE', '%' . $request->search_data . '%');
        }
        }

        // Filter by start_date
        if ($request->filled('start_date')) {
            $query->where('created_at', '>=', $request->start_date . ' 00:00:00');
        }

        // Filter by end_date
        if ($request->filled('end_date')) {
            $query->where('created_at', '<=', $request->end_date . ' 23:59:59');
        }

        // Filter by status
        if (
            $request->filled('status') &&
            in_array($request->status, ['success', 'pending', 'failed','rejected'])
        ) {
            $query->where('status', $request->status);
        }

        $data = $query->orderBy('id', 'DESC')->paginate(50);

        return view('user.payin.userpayin', compact('data'));
    }
}

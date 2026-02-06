<?php

namespace App\Http\Controllers\admin\payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Freeze;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;

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

    public function freezeamount(Request $request){
        $user=User::where('role_id',2)->get();
        $freezeamount=Freeze::leftJoin('users', 'users.id', '=', 'freezes.user_id')
       ->select('freezes.*', 'users.name as user_name')->paginate(20);
        return view('admin.freeze.index',compact('user','freezeamount'));
    }

    public function store(Request $request)
    {
       
        $check = Freeze::where('user_id', $request->user_id)->exists();
            if ($check) {
                return redirect('superadmin/freeze-amount')->with('success', 'Freeze amount already exists.');
            } else {
                Freeze::create([
                    'user_id' => $request->user_id,
                    'amount'  => $request->freeze_amount,
                ]);
            }
        return redirect('superadmin/freeze-amount')->with('success', 'Freeze amount Added Successfully.');
    }

    public function update(Request $request)
    {
        $data = Freeze::find($request->id);
        $data->amount = $request->amount;
        $data->save();
        return redirect()->back()->with('success', 'Freeze amount updated successfully!');
    }

    public function destroy($id)
    {
        $data = Freeze::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'Freeze amount deleted successfully!');
    }

    
}

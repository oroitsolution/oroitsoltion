<?php

namespace App\Http\Controllers\admin\charges;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Charge;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ChargesController extends Controller implements HasMiddleware
{
    public static function  middleware():array
    {
        return [
            new Middleware('permission:view charges', only:['index']),
            new Middleware('permission:edit charges', only:['edit']),
           
        ];
    }
    
    public function index()
    {
       $user=User::all();
       return view('admin.charges.index',compact('user'));
    }

   public function store(Request $request)
    {
        $request->validate([
        'user_id' => 'required|exists:users,id',
        'type' => 'required|string',
        'start_range' => 'required|numeric|min:0',
        'end_range' => 'required|numeric|gte:start_range',
        'charge_type' => 'required|string|in:fixed,percent',
        'charges' => 'required|numeric|min:0',
    ]);

        $exists = Charge::where([
            'user_id' => $request->user_id,
            'type' => $request->type,
            'start_range' => $request->start_range,
            'end_range' => $request->end_range,
            'charge_type' => $request->charge_type,
        ])->exists();

        if ($exists) {
            return response()->json([
                'errors' => [
                    'charges' => ['Charge already exists with these criteria.']
                ]
            ], 422);
        }

    Charge::create([
        'user_id'     => $request->user_id,
        'type'        => $request->type,
        'start_range' => $request->start_range,
        'end_range'   => $request->end_range,
        'charge_type' => $request->charge_type,
        'charges'     => $request->charges,
        'reserve_charges' => !empty($request->reserve_charges) ? $request->reserve_charges:0,
    ]);

    return response()->json(['message' => 'Charge saved successfully!']);
    }

    public function getUserCharges($id)
    {
        $charges = Charge::where('user_id', $id)->get();
        return response()->json(['data' => $charges]);
    }

    
    public function update(Request $request, Charge $charge)
    { 
        $request->validate([
        'user_id' => 'required|exists:users,id',
        'type' => 'required|string',
        'start_range' => 'required|numeric|min:0',
        'end_range' => 'required|numeric|gte:start_range',
        'charge_type' => 'required|string|in:fixed,percent',
        'charges' => 'required|numeric|min:0',
      ]);
       $charge = Charge::findOrFail($request->charge_id);
       $charge->update($request->all());

        return response()->json(['message' => 'Charge updated successfully']);
    }

  
    public function destroy($id)
    {
        $charge = Charge::findOrFail($id);
        $charge->delete();
        return response()->json(['message' => 'Charge deleted successfully']);
    }
}

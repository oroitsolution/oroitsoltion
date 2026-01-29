<?php

namespace App\Http\Controllers\Api\Payout;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PayoutresponseController extends Controller
{
    public function payoutresponse(Request $request){
        dd($request->all());
   }
}

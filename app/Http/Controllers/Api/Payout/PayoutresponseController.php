<?php

namespace App\Http\Controllers\Api\Payout;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class PayoutresponseController extends Controller
{
    public function payoutresponse(Request $request){
        dd($request->all());
   }
}

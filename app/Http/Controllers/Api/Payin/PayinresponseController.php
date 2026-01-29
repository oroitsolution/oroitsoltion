<?php

namespace App\Http\Controllers\Api\Payin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PayinresponseController extends Controller
{
   public function payinresponse(Request $request){
        dd($request->all());
   }
}

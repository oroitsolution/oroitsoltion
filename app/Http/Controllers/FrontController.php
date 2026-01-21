<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;


class FrontController extends Controller
{
    public function index(Request $request)
    {
        return view('front.index');
    }

    public function software(Request $request)
    {
        return view('front.software');
    }

    //---------------------------------------------------------------//

     public function ppc(Request $request)
    {
        return view('front.privacypolicy');
    }
     public function aboutus(Request $request)
    {
        return view('front.aboutus');
    }
     public function term_condition(Request $request)
    {
        return view('front.termscondition');
    }
     public function cancel_refundpolicy(Request $request)
    {
        return view('front.cancel_refund');
    }
     public function contact_us(Request $request)
    {
        return view('front.contact_us');
    }



    public function contactstore(Request $request)
    {
         $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'phone'  => 'required|numeric',
            'email'   => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Insert data and get inserted ID
        $contactId = DB::table('contacts')->insertGetId([
            'name'    => $validated['name'],
            'phone'  => $validated['phone'],
            'email'   => $validated['email'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'created_at' => Carbon::now('Asia/Kolkata'),
            'updated_at' => Carbon::now('Asia/Kolkata'),
        ]);

        return back()->with('success', 'Contact sent successfully!');
    }
}

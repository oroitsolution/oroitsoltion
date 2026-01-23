<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache; 
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManager;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\Encoders\PngEncoder;
use Intervention\Image\Encoders\WebpEncoder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Traits\ApiJsonResponse;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Kyc;
use App\Models\Clints;
use App\Models\additionlBankAccount;


class DashboardController extends Controller
{
   public function index(){

        return view('admin.dashboards');
    }

    public function contact(Request $request){
       
        $contact=DB::table('contacts') ->orderBy('id', 'desc')->paginate(10);
        return view('admin.contact.index',compact('contact'));
    }
}

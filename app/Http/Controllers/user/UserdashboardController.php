<?php

namespace App\Http\Controllers\user;

use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache; 
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\Encoders\PngEncoder;
use Intervention\Image\Encoders\WebpEncoder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Traits\ApiJsonResponse;
use Carbon\Carbon;
use App\Models\User;

class UserdashboardController extends Controller
{
    public function index(){
        $user = Auth::user();
        return view('user.userdashboard',compact( 'user'));
    }
}

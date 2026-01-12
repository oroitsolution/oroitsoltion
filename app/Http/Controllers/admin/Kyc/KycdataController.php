<?php

namespace App\Http\Controllers\admin\kyc;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\Encoders\PngEncoder;
use Intervention\Image\Encoders\WebpEncoder;
use Carbon\Carbon;
use App\Models\Kyc;
use App\Models\User;

class KycdataController extends Controller
{
    public function getkycdata()
    {
        $user = Auth::user();
        $kycdata = Kyc::with('user')->latest()->paginate(10);
        return view('admin.kyc.Adminkyc',compact('kycdata','user'));
    }

    public function updateStatus($id, $status)
    {
        $kyc = Kyc::findOrFail($id);
        $kyc->kyc_status = $status;
        $kyc->save();

        return back()->with('success', 'KYC status updated successfully.');
    }

}

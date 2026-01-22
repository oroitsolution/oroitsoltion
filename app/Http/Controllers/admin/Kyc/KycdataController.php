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
use App\Models\Clints;

class KycdataController extends Controller
{
     private function generateClientId(): string
    {
        do {
            $clientId = 'OROIT-' . strtoupper(Str::random(12));
        } while (Clints::where('client_id', $clientId)->exists());

        return $clientId;
    }
    
    public function getkycdata()
    {
        $user = Auth::user();
        $kycdata = Kyc::with('user')->latest()->paginate(10);
        return view('admin.kyc.Adminkyc',compact('kycdata','user'));
    }


   public function updateStatus(Request $request, $id)
        {
            // ✅ Validate request
            $request->validate([
                'status'  => 'required|in:APPROVED,REJECTED',
                'user_id' => 'required|exists:users,id',
            ]);

            // ✅ Map status
            $kycStatus = $request->status === 'APPROVED' ? 1 : 2;

            // ✅ Update KYC table
            $kyc = Kyc::findOrFail($id);
            $kyc->kyc_status = $kycStatus;
            $kyc->save();

            // ✅ Update USER KYC flag
            User::where('id', $request->user_id)
                ->update(['user_kyc' => $kycStatus]);

            // ✅ ONLY WHEN APPROVED → generate client
            if ($kycStatus === 1) {
                $secret = 'ORO-' . strtoupper(Str::random(16)) . '-' . time();
                $client = Clints::where('user_id', $request->user_id)->first();

                    if (!$client) {
                        Clints::create([
                            'user_id'   => $request->user_id,
                            'client_id' => $this->generateClientId(),
                            'secret_id' => $secret,
                            'ipaddress' => request()->ip(),
                        ]);
                    }

                    Clints::where('user_id', $request->user_id)->update([
                        'client_id' => $this->generateClientId(),
                        'secret_id' => $secret,
                        'ipaddress' => '192.168.1.10',
                    ]);

            }

            return response()->json([
                'success' => true,
                'message' => 'KYC status updated successfully.'
            ]);
        }

   




}

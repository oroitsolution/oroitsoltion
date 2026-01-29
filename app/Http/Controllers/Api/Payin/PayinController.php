<?php

namespace App\Http\Controllers\Api\Payin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use App\Models\Payin;

class PayinController extends Controller
{
   public function payindata(Request $request)
    {
        $clientdata = $request->get('auth_user');
        $clientUrl  = $clientdata->payin_url ?? null;

        if (!$clientUrl) {
            return response()->json([
                'success' => false,
                'message' => 'Payin Callback URL not found.'
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = User::find($clientdata->user_id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.'
            ], Response::HTTP_NOT_FOUND);
        }

        // ✅ Validation
        $rules = [
            'name'          => 'required|string|max:255',
            'amount'        => 'required|numeric|min:300|max:3000',
            'mobile_number' => 'required|string|max:15',
            'order_id'      => 'required|string|unique:payins,order_id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // ✅ Payload
        $payload = [
            'amount' => $request->amount,
            'name'   => $request->name,
            'number' => $request->mobile_number,
        ];

        if ($user->payinmethod === 'moneydash')
        {
            if ($user->payintype === 'NewMoneyApi') 
                {
                    $curl = curl_init();

                    curl_setopt_array($curl, [
                        CURLOPT_URL            => 'https://moneydashtechsol.in/api/v1/payin/initiate',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_TIMEOUT        => 30,
                        CURLOPT_CUSTOMREQUEST  => 'POST',
                        CURLOPT_POSTFIELDS     => json_encode($payload),
                        CURLOPT_HTTPHEADER     => [
                            'X-API-KEY: api_qXspRnNqHzOARWWBLLbRw8IOY25xlEPXpqmuRZtb',
                            'Content-Type: application/json',
                        ],
                    ]);

                    $response = curl_exec($curl);
                    curl_close($curl);

                    if (!$response) {
                        return response()->json([
                            'status'  => 'error',
                            'message' => 'Moneydash API not responding'
                        ], 500);
                    }

                    $responseData = json_decode($response, true);
                   
                    if (!isset($responseData['data']['txn_id'])) {
                        return response()->json([
                            'status'  => 'error',
                            'message' => 'Invalid response from Orodashboard',
                            'data'    => $responseData
                        ], 500);
                    }

                    // ✅ Save Payin
                    $payinId = Payin::insert([
                        'user_id'            => $user->id,
                        'systemgenerateid'   => $responseData['data']['txn_id'],
                        'amount'             => $request->amount,
                        'order_id'           => $request->order_id,
                        'data_request'       => json_encode($payload),
                        'url'                => $responseData['data']['qr_code'] ?? null,
                        'data_request_response'  => json_encode($responseData),
                        'created_at'         => now(),
                    ]);

                    return response()->json([
                        'status'   => true,
                        'message'  => 'Payin payment initiated successfully',
                        'type'     => 'qrcode',
                        'trx_id'   => $responseData['data']['txn_id'],
                        'order_id' => $request->order_id,
                        'url'      => $responseData['data']['qr_code'] ?? null,
                        
                    ]);
                }elseif($user->payintype === 'cashfree'){
                    $payload['return_url'] = $clientUrl;
            
                     $curl = curl_init();

                    curl_setopt_array($curl, [
                        CURLOPT_URL            => 'https://moneydashtechsol.in/api/v1/payin/moneydesh/initiate',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_TIMEOUT        => 30,
                        CURLOPT_CUSTOMREQUEST  => 'POST',
                        CURLOPT_POSTFIELDS     => json_encode($payload),
                        CURLOPT_HTTPHEADER     => [
                            'X-API-KEY: api_qXspRnNqHzOARWWBLLbRw8IOY25xlEPXpqmuRZtb',
                            'Content-Type: application/json',
                        ],
                    ]);

                    $response = curl_exec($curl);
                    curl_close($curl);

                    if (!$response) {
                        return response()->json([
                            'status'  => 'error',
                            'message' => 'Moneydash API not responding'
                        ], 500);
                    }

                    $responseData = json_decode($response, true);

                    if (!isset($responseData['data']['transaction_id'])) {
                        return response()->json([
                            'status'  => 'error',
                            'message' => 'Invalid response from Orodashboard',
                            'data'    => $responseData
                        ], 500);
                    }

                    // ✅ Save Payin
                    $payinId = Payin::insert([
                        'user_id'            => $user->id,
                        'systemgenerateid'   => $responseData['data']['transaction_id'],
                        'amount'             => $request->amount,
                        'order_id'           => $request->order_id,
                        'data_request'       => json_encode($payload),
                        'url'                => $responseData['data']['payment_url'] ?? null,
                        'data_request_response'  => json_encode($responseData),
                        'created_at'         => now(),
                    ]);

                    return response()->json([
                        'status'   => true,
                        'message'  => 'Payin payment initiated successfully',
                        'type'     => 'intent',
                        'trx_id'   => $responseData['data']['transaction_id'],
                        'order_id' => $request->order_id,
                        'url'      => $responseData['data']['qr_code'] ?? null,
                        
                    ]);
                }

                return response()->json([
                    'status'  => 'error',
                    'message' => 'Invalid payin method'
                ], 400);

        }
    }

}

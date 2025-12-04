<?php
namespace App\Services;
use Illuminate\Support\Facades\Http;

class SubmerchantService
{
    public function submerchant()
    {
        $curl = curl_init();

            curl_setopt_array($curl, [
            CURLOPT_URL => "https://stoplight.io/mocks/easebuzz/payment-gateway/88417588/merchant/v1/submerchant/create/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode([
                'merchant_details' => [
                    'merchant_key' => 'RXXXXX5ZA',
                    'hash' => '99f59e29b2b68304acc0a0e5095294a7ab2e83e1dde44eafba56d59f4b1ab29ca398f766f64f7eeae5fdba351cb9043acf5c1f1f89f8d22308436893364059b7'
                ],
                'submerchant_details' => [
                    'sub_merchant_name' => 'Rushi Agarwal',
                    'sub_merchant_email' => 'newdocs@gmail.com',
                    'sub_merchant_phone' => '629XXXXXX65',
                    'sub_merchant_name_in_bank' => 'Rushi',
                    'sub_merchant_account_number' => '192XXXXXX108',
                    'sub_merchant_bank_name' => 'ICICI',
                    'sub_merchant_branch_name' => 'Bankura',
                    'sub_merchant_ifsc_code' => 'ICIXXXXX25',
                    'sub_merchant_password' => 'XXXXXXXXX',
                    'sub_merchant_confirm_password' => 'XXXXXXXXXX'
                ]
            ]),
            CURLOPT_HTTPHEADER => [
                "Accept: application/json",
                "Content-Type: application/json"
            ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
            echo "cURL Error #:" . $err;
            } else {
           return json_decode($response);
            }
    }


  

}
?>

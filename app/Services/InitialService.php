<?php
namespace App\Services;
use Illuminate\Support\Facades\Http;

class InitialService
{
    public function initiateservice()
    {
     
        $curl = curl_init();

        $data = [
            "key" => "",
            "txnid" => "",
            "amount" => "",
            "productinfo" => "",
            "firstname" => "",
            "phone" => "",
            "email" => "",
            "surl" => "",
            "furl" => "",
            "hash" => "",
            "udf1" => "",
            "udf2" => "",
            "udf3" => "",
            "udf4" => "",
            "udf5" => "",
            "udf6" => "",
            "udf7" => "",
            "address1" => "",
            "address2" => "",
            "city" => "",
            "state" => "",
            "country" => "",
            "zipcode" => "",
            "show_payment_mode" => "",
            "split_payments" => "",
            "request_flow" => "",
            "sub_merchant_id" => "",
            "payment_category" => "",
            "account_no" => "",
            "ifsc" => ""
        ];
        
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://stoplight.io/mocks/easebuzz/payment-gateway/88397287/payment/initiateLink",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => http_build_query($data), // Properly encoded form data
            CURLOPT_HTTPHEADER => [
                "Accept: application/json",
                "Content-Type: application/x-www-form-urlencoded"
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

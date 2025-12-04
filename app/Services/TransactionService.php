<?php
namespace App\Services;
use Illuminate\Support\Facades\Http;

class TransactionService
{
    public function firstapi()
    {
        $curl = curl_init();

        // Add your API key here securely (consider using environment variables)
        $apiKey = env('EASEBUZZ_API_KEY', 'your_api_key_here');

        $postData = [
            'txnid' => 'EBZTestTxn0001',
            'key' => $apiKey,
            'amount' => 10,
            'email' => 'sagar.sawant@easebuzz.in',
            'phone' => '8805596828',
            'hash' => '7c36ca4836a6b4af19e4966f2af90bb6c05a235ec35840662deb9f6302b38eab6d1d75e8401cacef7647ed4e9e9807b58ffca00ee9c61e4fdbbcb5e49a8563d4'
        ];

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://stoplight.io/mocks/easebuzz/payment-gateway/88393071/transaction/v1/retrieve",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($postData),
            CURLOPT_HTTPHEADER => [
                "Accept: application/json",
                "Content-Type: application/x-www-form-urlencoded"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return [
                'success' => false,
                'message' => 'cURL Error: ' . $err
            ];
        }

        return json_decode($response, true);
    }


    public function secondapi()
    {
        $curl = curl_init();
    
        // Fetch API key securely
        $apiKey = env('EASEBUZZ_API_KEY', 'your_api_key_here');
    
        $postData = [
            'txnid' => '202409-01',
            'key' => $apiKey,
            'hash' => '2974be5409be37a882197b52d0acffd3ff2fc8f0207049d87bd091195236e9a8ab25f50c040aa752f1e0640ebbadf201cd1b09427d77b83dd7e18842d250c1af'
        ];
    
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://stoplight.io/mocks/easebuzz/payment-gateway/88393071/transaction/v2.1/retrieve",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => http_build_query($postData), // Encode array properly
            CURLOPT_HTTPHEADER => [
                "Accept: application/json",
                "Content-Type: application/x-www-form-urlencoded"
            ],
        ]);
    
        $response = curl_exec($curl);
        $err = curl_error($curl);
    
        curl_close($curl);
    
        if ($err) {
            return [
                'success' => false,
                'message' => 'cURL Error: ' . $err
            ];
        }
   
        return json_decode($response, true);
    }
    

    public function transactionByDate()
    {
       
        $curl = curl_init();
        
        if ($curl === false) {
            die("Failed to initialize cURL.");
        }
        
        $postData = [
            'merchant_key'    => '',
            'transaction_date'=> '',
            'merchant_email'  => '',
            'hash'            => '',
            'submerchant_id'  => ''
        ];
        
        curl_setopt_array($curl, [
            CURLOPT_URL            => "https://stoplight.io/mocks/easebuzz/payment-gateway/88393071/transaction/v1/retrieve/date",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => "",
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => http_build_query($postData), // Properly encode POST fields
            CURLOPT_HTTPHEADER     => [
                "Accept: application/json",
                "Content-Type: application/x-www-form-urlencoded"
            ],
        ]);
        
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
            return [
                'error' => true,
                'message' => "cURL Error: " . $err
            ];
        } 
        
        $decodedResponse = json_decode($response, true);
        
        if ($httpCode >= 200 && $httpCode < 300) {
            return $decodedResponse; // Success response
        } 
        
        return [
            'error' => true,
            'http_code' => $httpCode,
            'response' => $decodedResponse
        ];
        
        
    }

    public function transbydaterange(){

            $curl = curl_init();

            curl_setopt_array($curl, [
            CURLOPT_URL => "https://stoplight.io/mocks/easebuzz/payment-gateway/88393071/transaction/v2/retrieve/date%E2%80%AC",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode([
                'key' => 'XXXXXXXXXXX',
                'hash' => 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX',
                'merchant_email' => 'XXXXXXXXXXX',
                'date_range' => [
                    'start_date' => '10-05-2024',
                    'end_date' => '23-08-2024'
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
           
            return(json_decode($response));
            
            }
    }

}
?>

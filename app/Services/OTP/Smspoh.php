<!--ORIGINAL CODE-->

// <?php

// namespace App\Services\OTP;

// use App\Contracts\SendSms;

// class SMSPoh implements SendSms
// {
//     public function send($to, $from, $text, $template_id = null)
//     {
//         $api_key = env("SMSPOH_API_KEY"); // Your SMSPoh API key
//         $sender_id = env("SMSPOH_SENDER_ID"); // Your SMSPoh Sender ID

//         $params = [
//             "api_key" => $api_key,
//             "to" => $to,
//             "message" => $text,
//             "sender" => $sender_id,
//         ];

//         $url = "https://www.smspoh.com/api/v2/send";
//         $params = http_build_query($params); // Format parameters for URL query string

//         $ch = curl_init(); // Initialize cURL
//         curl_setopt($ch, CURLOPT_URL, $url . '?' . $params);
//         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
//         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//         curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); // SMSPoh uses GET requests
//         $response = curl_exec($ch);

//         if (curl_errno($ch)) {
//             // Handle cURL error
//             return json_encode(["error" => curl_error($ch)]);
//         }

//         curl_close($ch);

//         $response = json_decode($response, true);

//         // Check for success
//         if (isset($response['status']) && $response['status'] === 'success') {
//             return $response;
//         }

//         return json_encode(["error" => "Failed to send SMS", "response" => $response]);
//     }
// }

// END ORIGINAL CODE




//UPDATE CODE




<?php

namespace App\Services\OTP;

use App\Contracts\SendSms;

class Smspoh implements SendSms {
    public function send($to, $from, $text, $template_id) {
        
        dd("REEEE");
        
        $authToken = 'iBpO640k39bO9EWINRw_ZbVVLtRwm0-FbN_RmkxFUMqWkhXavjhVKLP6S9iGErXO';

        $params = [
            "to" => $to,
            "message" => $text,
            "sender" => "SmartCity11"
        ];

        $url = "https://smspoh.com/api/v2/send";
        $params = json_encode($params);


        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $authToken,
            'Content-Length: ' . strlen($params)
        ];

        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}













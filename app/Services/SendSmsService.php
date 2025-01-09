<?php

namespace App\Services;

use App\Models\OtpConfiguration;


class SendSmsService
{
    //START ORIGINAL CODE  (This portion is used for dynamic SMS services)
        // public function sendSMS($to, $from, $text, $template_id)
        // {
        //     $otp = OtpConfiguration::where('value', 1)->first()->type;
        //     $otp_class = __NAMESPACE__ . '\\OTP\\' . str_replace(' ', '', ucwords(str_replace('_', ' ', $otp)));
            
        //     if (class_exists($otp_class)) {
        //         return (new $otp_class)->send($to, $from, $text, $template_id);
        //     } else {
        //         return;
        //     }
        // }
    // END ORIGINAL CODE
    
   
   //START UPDATE CODE (SMSPoh)
    public function sendSMS($to, $from, $text, $template_id)
    {
       
        $api_key = env("SMSPOH_KEY", 'iBpO640k39bO9EWINRw_ZbVVLtRwm0-FbN_RmkxFUMqWkhXavjhVKLP6S9iGErXO'); // Your SMSPoh API key
        $sender_id = env("SMSPOH_SENDER_ID", 'SmartCity11');
        
        $url = env("SMSPOH_ENDPOINT", 'https://smspoh.com/api/v2/send');

        $data = [
            "to" => $to,
            "message" => $text,
            "sender" => $sender_id,
            "from" => $sender_id,
        ];

        $jsonData = json_encode($data);
        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $api_key,
            'Content-Length: ' . strlen($jsonData),
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'cURL error: ' . curl_error($ch);
        } else {
            echo 'Response: ' . $response;
        }
        curl_close($ch);
        
        return;
    }
    //END UPDATE CODE (SMSPoh)
    
}

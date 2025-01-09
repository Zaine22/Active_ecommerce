<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\PasswordReset;
use Auth;
use App\Models\User;
use App\Utility\SmsUtility;
use Hash;

class OTPVerificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function verification(Request $request){
        if (Auth::check() && Auth::user()->email_verified_at == null) {
            return view('otp_systems.frontend.auth.'.get_setting('authentication_layout_select').'.user_verification');
        }
        else {
            flash('You have already verified your number')->warning();
            return redirect()->route('home');
        }
    }


    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function verify_phone(Request $request){
      
        $user = Auth::user();
        if ($user->verification_code == $request->verification_code) {
            $user->email_verified_at = date('Y-m-d h:m:s');
            $user->save();
            offerUserWelcomeCoupon();
            flash('Your phone number has been verified successfully')->success();
            return redirect()->route('home');
        }
        else{
            flash('Invalid Code')->error();
            return back();
        }
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function resend_verificcation_code(Request $request){
 
        $user = Auth::user();
        $user->verification_code = rand(100000,999999);
        $user->save();
        SmsUtility::phone_number_verification($user);

        return back();
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function reset_password_with_code(Request $request)
    {
        $phone = "+{$request['country_code']}{$request['phone']}";
        
        if (($user = User::where('phone', $phone)->where('verification_code', $request->code)->first()) != null) {
            if ($request->password == $request->password_confirmation) {
                $user->password = Hash::make($request->password);
                $user->email_verified_at = date('Y-m-d h:m:s');
                $user->save();
                event(new PasswordReset($user));
                auth()->login($user, true);

                if (auth()->user()->user_type == 'admin' || auth()->user()->user_type == 'staff') {
                    flash("Password has been reset successfully")->success();
                    return redirect()->route('admin.dashboard');
                }
                flash("Password has been reset successfully")->success();
                return redirect()->route('home');
            } else {
                flash("Password and confirm password didn't match")->warning();
                return view('otp_systems.frontend.auth.'.get_setting('authentication_layout_select').'.reset_with_phone');
            }
        } else {
            flash("Verification code mismatch")->error();
            return view('otp_systems.frontend.auth.'.get_setting('authentication_layout_select').'.reset_with_phone');
        }
    }

  
    /**
     * @param  User $user
     * @return void
     */

    public function send_code($user){
        SmsUtility::phone_number_verification($user);
    }

    /**
     * @param  Order $order
     * @return void
     */
    public function send_order_code($order){
        $phone = json_decode($order->shipping_address)->phone;
        if($phone != null){
            SmsUtility::order_placement($phone, $order);
        }
    }

    /**
     * @param  Order $order
     * @return void
     */
    public function send_delivery_status($order){
        $phone = json_decode($order->shipping_address)->phone;
        if($phone != null){
            SmsUtility::delivery_status_change($phone, $order);
        }
    }

    /**
     * @param  Order $order
     * @return void
     */
    public function send_payment_status($order){
        $phone = json_decode($order->shipping_address)->phone;
        if($phone != null){
            SmsUtility::payment_status_change($phone, $order);
        }
    }

    public function account_opening($user, $password){
        if($user->phone != null){
            SmsUtility::account_opening($user, $password);
        }
    }

    public function sendOtp(Request $request){
        $phone = '+'.$request->country_code.$request->phone;
        return $this->handleOtpSending($phone);
    }

    public function resendOtp($phone){
        return $this->handleOtpSending($phone);
    }

    public function handleOtpSending($phone){
        $user = User::where('phone', $phone)->first();
        if ($user != null) {
            
            if($user->otp_code != null && $user->otp_sent_time != null){
                $resendWaitTime = 180;
                $elapsedTime = strtotime(date("Y-m-d H:i:s")) -  strtotime($user->otp_sent_time);
                $resendOtpTimeLeft = max($resendWaitTime - $elapsedTime, 0);
                if($resendOtpTimeLeft > 0){
                    flash(translate('Please wait').' '.($resendOtpTimeLeft-1).' '.('seconds before trying again.'))->error();
                    return back();
                }
            }

            $user->otp_code = rand(100000,999999);
            $user->otp_sent_time = date("Y-m-d H:i:s");
            $user->save();
            SmsUtility::loginWithOtp($user);
            return redirect()->route('otp-verification-page', ['user_id' => encrypt($user->id)]);
        }
        else {
            flash(translate('No account exists with this phone number'))->error();
            return back();
        }
    }
    public function otpVerificationPage(Request $request){
        $user = User::where('id', decrypt($request->user_id))->first();
        $phone = $user->phone;

        $resendWaitTime = 180;
        $elapsedTime = strtotime(date("Y-m-d H:i:s")) -  strtotime($user->otp_sent_time);
        $resendOtpTimeLeft = max($resendWaitTime - $elapsedTime, 0);

        return view('otp_systems.frontend.auth.'.get_setting('authentication_layout_select').'.otp_verification', compact('phone', 'resendOtpTimeLeft'));
    }
    
    public function validateOtpCode(Request $request){
        $user = User::wherePhone($request->phone)->whereOtpCode($request->otp_code)->first();
        if($user != null){

            $otpValidityDuration  = 300;
            $elapsedTime = strtotime(date("Y-m-d H:i:s")) -  strtotime($user->otp_sent_time);
            $otpValidityPeriodLeft = max($otpValidityDuration - $elapsedTime, 0);
            if($otpValidityPeriodLeft < 1){
                flash(translate('Your OTP code has expired. Please request a new one.'))->error();
                return back();
            }

            $user->otp_code = null; 
            $user->otp_sent_time = null;
            
            $user->save();
            auth()->login($user, true);
            flash("Logged in successfully")->success();
            return redirect()->route('home');
        }
        else{
            flash("OTP do not matched")->error();
            return back();
        }
    }
}

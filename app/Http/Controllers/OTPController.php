<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OtpConfiguration;

class OTPController extends Controller
{
    public function __construct() {
        // Staff Permission Check
        $this->middleware(['permission:otp_configurations'])->only('configure_index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function configure_index()
    {
        // $otp_configurations = OtpConfiguration::all();   //To Show All SMS services ( For Dynamic Services)
        
        $otp_configurations = OtpConfiguration::where('type', 'smspoh')->get();  //This is used only for SMSPoh Service
        
        return view('backend.otp_systems.configurations.index', compact('otp_configurations'));
    }

    public function loginConfigure(){
        return view('backend.otp_systems.configurations.login_configuration');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateActivationSettings(Request $request)
    {
        $otp_configuration = OtpConfiguration::where('type', $request->type)->first();
        if($otp_configuration!=null){
            $otp_configuration->value = $request->value;
            $otp_configuration->save();
        }
        else{
            $otp_configuration = new OtpConfiguration;
            $otp_configuration->type = $request->type;
            $otp_configuration->value = $request->value;
            $otp_configuration->save();
        }
        if($request->value == 1){
            OtpConfiguration::where('id','!=', $otp_configuration->id)
                        ->where('value', 1)
                        ->update(['value' => 0 ]);
        }
        return '1';
    }

    /**
     * Update the specified resource in .env
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update_credentials(Request $request)
    {
        foreach ($request->types as $key => $type) {
                $this->overWriteEnvFile($type, $request[$type]);
        }

        flash("Settings updated successfully")->success();
        return back();
    }

    /**
    *.env file overwrite
    */
    public function overWriteEnvFile($type, $val)
    {
        $path = base_path('.env');
        if (file_exists($path)) {
            $val = '"'.trim($val).'"';
            if(is_numeric(strpos(file_get_contents($path), $type)) && strpos(file_get_contents($path), $type) >= 0){
                file_put_contents($path, str_replace(
                    $type.'="'.env($type).'"', $type.'='.$val, file_get_contents($path)
                ));
            }
            else{
                file_put_contents($path, file_get_contents($path)."\r\n".$type.'='.$val);
            }
        }
    }
}

<?php

namespace App\Http\Controllers\API\Password;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\VerificationCode;
use App\User;
use Illuminate\Support\Facades\Hash;


class PasswordController extends Controller
{
    public function forgotPassword(Request $request){

        $user = User::where('email',$request->email)->first();

        if ($user == "") {
            return response()->json([ 'status' => false ,'message' => trans("messages.no_user_with_email" )]);  
        }

        $route = $this->OTPMessageSend($user->email ,$user->user_id);
        
        if($route == true){
            return \Response::json([
                'status'  => true,
                'message' => 'OTP has been sent successfully to your email address.'
            ]);
        }

        return response()->json([ 'status'  => true, 'message' => trans('messages.password_sent')]);
    }

    public function OTPMessageSend($email,$user_id){
        $user = User::where('email',$email)->first();
        $OTP_msg = substr(str_shuffle("0123456789"), 0, 4);          //generate new OTP message

        $verification_data = VerificationCode::where('user_id',$user->id)->get();
        $data = array(
            'user_id' => $user->id,
            'code' => $OTP_msg,
            'date'=>date('Y-m-d'),
            'time'=>date('H:i:s')
        );

        if(count($verification_data) != 0){
            VerificationCode::where('user_id',$user->id)->delete();
        }

        VerificationCode::create($data);
        $to = $user->email;
        $from = env('MAIL_USERNAME');
        $name = $user->name;
        $mail_data = "<p><strong>Your verification OTP&nbsp; is </strong>".$data['code']."</p>\n<p>Thank you for using our application!</p>\n<p>Regards,<br />". env('APP_NAME') ."</p>";
        $mail_subject = "Your Password Verification Code | ".env('APP_NAME');
        sendMail($to,$from,$mail_data,$mail_subject);
        return true;
    }

    public function VerificationOTPCheck(Request $request){
        $date = date('Y-m-d');
        $user = User::where('email',$request->email)->first();
        if($user != null)
        {
            $verification_otp = VerificationCode::where('user_id',$user->id)->where('code',$request->code)->first();
            if($verification_otp != null ){
                $time = date("i",strtotime($verification_otp->time));
                $current_time = date('i');
                if( ($current_time - $time) >= 10){
                    return \Response::json([
                        'status'  => false,
                        'message' => 'Your OTP has been expired.'
                    ]);
                }else{
                        return \Response::json([
                            'status'  => true,
                            'user_id' => $verification_otp->user_id,
                            'message' => 'Your OTP has been verified successfully.'
                        ]);
                }
            }else{
                return \Response::json([
                    'status'  => false,
                    'message' => 'Your OTP is wrong! Please try again'
                ]);    
            }
        }else{
            return \Response::json([
                'status'  => false,
                'message' => 'We can not found your account!'
            ]);
        }
    }

    public function ResendOTP(Request $request){ 
        $user = \App\User::where('email',$request->email)->first();
        if($user != null)
        {
            $check = $this->OTPMessageSend($user->email,$user->user_id);
            if($check){
                return \Response::json([
                    'status'  => true,
                    'message' => 'OTP send on your email'
                ]);
            }else{
                return \Response::json([
                    'status'  => true,
                    'message' => 'Server problem please try later.'
                ]);
            }
        }else{
            return \Response::json([
                'status'  => false,
                'message' => 'We can not found your account!'
            ]);
        }
    }

    public function updatePassword(Request $request){
        $password = Hash::make($request->password);
        $user = isset($request->email) ? $request->email : 0;
        $result= \App\User::where('email',$user)->update(['password'=>$password]);
        if($result){
            return \Response::json([
                'status'  => true,
                'message' => 'Password has been reset successfully.'
            ]);
        }else{
            return \Response::json([
                'status'  => true,
                'message' => 'Server problem please try later.'
            ]);
        }
    }

    public function changePassword(Request $request){
        $user = User::where('id',\Auth::user()->id)->first();

        if($user == "") {
                $message = trans('messages.user_not_found');
                return response()->json([ 'status' => false ,'message' => $message ]);   
        }
           
        $hashedPassword = $user->password;
        $match=Hash::check($request->old_password, $hashedPassword);
        $same_exits=Hash::check($request->new_password, $hashedPassword);
        if ($match) {
                if($same_exits){
                    $message = trans('messages.old_new_pass_same');
                    return response()->json([ 'status' => false ,'message' => $message ]);
                }                   

			$user->fill([
                'password' => Hash::make($request->new_password)
            ])->save();
           
            $message = trans('messages.password_change');
            return response()->json([ 'status' => true ,'message' => $message ]);
           
        }else{
            $message = trans('messages.valid_password');
            return response()->json([ 'status' => false ,'message' => $message ]);
        }
    }
}
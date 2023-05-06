<?php
namespace App\Http\Controllers\API\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Feedback;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UserRequest;
use File;
class UserController extends Controller
{
public $successStatus = 200;

    public function login(){
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();       
            if($user->device_id != request('device_id')){
                $user_device = \App\User::where('device_id',request('device_id'))->first();
                if($user_device != null){
                    $user_device->registration_id = null;
                    $user_device->device_id = null;
                    $user_device->save();
                }
            }
            if(request('registration_id') != null){
                $user->registration_id = request('registration_id');
            }
            $user->device_id = request('device_id');
            $user->save();
            $success = $user;
            $success['api_token'] =  $user->createToken('auth_token')->plainTextToken;;
            $success['image'] = getSingleMedia($user,'profile_image',null);
            unset($success['media']);
            return response()->json([ 'data' => $success ], 200 );
        }
        else{
            $message = trans('messages.auth_failed');
            return comman_message_response($message,400);
        }
    }

    public function register(UserRequest $request){
        $input = $request->all();
                
        $password = $input['password'];
        $input['user_type'] = !empty($input['user_type']) ? $input['user_type'] : 'user';
        $input['password'] = Hash::make($password);

        $user = User::create($input);
        // $user->assignRole($input['user_type']);
        $input['api_token'] = $user->createToken('auth_token')->plainTextToken;

        unset($input['password']);
        $message = trans('messages.save_form',['form' => 'user' ]);
        $user->api_token = $user->createToken('auth_token')->plainTextToken;
        $response = [
            'message' => $message,
            'data' => $user
        ];
        return comman_custom_response($response);
    }

    public function updateUserProfile(Request $request){
        $data = $request->all();
        $user = User::updateOrCreate(['id' => $data['id'] ], $data);
            
        if(isset($request->profile_image) && $request->profile_image != null ) {
            $user->clearMediaCollection('profile_image');
            $user->addMediaFromRequest('profile_image')->toMediaCollection('profile_image');
        }
        
        $message = trans('messages.update_form',['form' => 'User profile']);
        $user_detail = User::where('id',optional($user)->id)->first(); 
       
        $user_detail['image'] = getSingleMedia($user_detail,'profile_image',null); 
        $response = [
            'data' => $user_detail,
            'message' => $message
        ];
        return comman_custom_response( $response );
    }

    public function saveFeedBack(Request $request){
		$validator = \Validator::make($request->all(), [
            'name'  => 'required',
            'email' => 'required|email',
            'comment' => 'required',
        ]);

        if ($validator->fails())
        {
                return \Response::json([
                    'status' => false,
                    'errors' => $validator->getMessageBag()->all()
                ]);
        }
        $temp = $request->all();
        Feedback::create($temp);

        return response()->json(['status' => true,'message' => trans('messages.save_form' ,['form' => 'Your feedback'])]);
    }

    public function logout(Request $request){
        $user = \Auth::user();

        if($request->is('api*')){
            $user->registration_id = null;
            $user->device_id = null;
            $user->save();
            return response()->json(['status' => true ,'message' => trans('messages.logout')]);
        }else{
            \Auth::logout();
            return redirect('/')->withSuccess('messages.logout');
        }
    }
}

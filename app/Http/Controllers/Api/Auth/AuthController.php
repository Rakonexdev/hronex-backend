<?php

namespace App\Http\Controllers\Api\Auth;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Employee\Employees;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

use App\Http\Controllers\Api\BaseController as BaseController;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;
use Hash;

use App\Notifications\AllNotification;
use Illuminate\Support\Facades\Notification;

class AuthController extends BaseController
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($data)) {
            return $this->sendError('Unauthorised.', ['error'=>trans('messages.error_login')]);            
        }

        $validator = Validator::make($request->all(), [
            // 'device_token' => 'required',       
            'device_token' => 'nullable|string',     
        ]);

      
        if ($validator->fails()) {
            return $this->sendError('Unauthorised.', ['error'=>trans('messages.error_login')]);
        }

        /*Firebase Token handling*/        
        $notif = new AllNotification();
        $device_token_save = $notif->saveToken($request);
        if(1 == $device_token_save){
            $success['device_token'] = $request->device_token;
        }else{
            $success['device_token'] = '';
        }

        /*Get employee data */
        $emp_data = Employees::select('id')->where('user_id', auth()->user()->id)->first();
        if($emp_data){
            $employee_id = $emp_data->id;
        }else{
            $employee_id = 0;
        }

        $success['user'] = auth()->user(); 
        $success['token'] = auth()->user()->createToken('API Token')->accessToken;
        $success['qr_data'] = enc_dec_data_new($employee_id, 'enc');
        $success['employee_id'] =  $employee_id;
        $success['success']   =  true;
        $msg   = trans('messages.success_login');
        
        return $this->sendResponse($success, $msg);
        /*return response()->json(['success' => true, 'user' => auth()->user(), 'token' => $token]);*/
    }

    public function logout(Request $request)
    {
        /*Firebase Token handling*/
        $notif = new AllNotification();
        $device_token_remove = $notif->removeToken($request);

        if(0 == $device_token_remove){
            $msg = trans('messages.dvc_tkn_remove_err').' & '.trans('messages.success_logout');
        }else{
            $msg = trans('messages.success_logout');
        }

        $request->user()->token()->revoke();

        return response()->json([
            'success' => true,
            'message' => $msg
        ]);
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $token = Str::random(64);
        try
        {
            \DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);

            $token = $token."_mail_".$request->email;
            Mail::send('emails.passwordforgot', ['token' => $token], function($message) use($request){
                $message->to($request->email);
                $message->subject('Reset Password');
            });

            $msg = trans('messages.forgotpass_email');

            return response()->json(['status' => 'success', 'message' => $msg], 200);
        }
        catch(Exception $e){
            $msg = trans('messages.errorCom');

            return response()->json(['status' => 'error', 'message' => $msg], 500);
        }
    }

    public function reachOut(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('users', 'email') // check if email is unique in the 'users' table
                ],
                'message' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $hrRole = Role::where('name', HR_ROLE)->first();                
            $user_id = User::role($hrRole)->first();
            $admin_email = $user_id->email;

            //$admin_email = User::where('is_admin', 1)->first();

            Mail::send('emails.reachout', ['request' => $request], function($message) use($admin_email){
                $message->to($admin_email);
                $message->subject('New Account request');
            });

            return response()->json([
                'success' => true,
                'message' => trans('messages.successS') /* 'Your message has been sent successfully.'*/
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => trans('messages.errorCom'),
                'error' => $e->getMessage()
            ], 500);
        }
    }

       public function updateYourPassword(Request $request)
    {
        $user_id = auth()->user()->id;

        try
        {   
            $validator = $request->validate([       
                'password' => 'required',
                'cpassword' => 'required|string|min:6'
            ]);
            $user = User::find($user_id);
            if (!Hash::check($request->password, $user->password)) {
                return $this->sendError(trans('messages.incorrect_current_password')); 
            }
            if ($request->password === $request->cpassword) {
                        return $this->sendError(trans('messages.new_password_same_as_current'));
                    }
            // $user = User::where('id', $user_id)
            //         ->update(['password' => Hash::make($request->password)]);
            $user->password = Hash::make($request->cpassword);
            $user->save();

            // if(!$user){
            //     return $this->sendError(trans('messages.unatuhorised'));
            // }

            $success['success'] =  true;
            $msg = trans('messages.password_changed');
            return $this->sendResponse($success, $msg);

        }catch (\Exception $e) {  

            $msg   = $e->getMessage(); /*trans('messages.errorCom');*/
            return $this->sendError($msg);

        }

        
    }

    public function terms()
    {
        return view('auth.terms');
    }

    public function privacy()
    {
        return view('auth.privacy');
    }

}
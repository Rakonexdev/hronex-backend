<?php
  
namespace App\Http\Controllers\Auth;
  
use Hash;
use Image;
use Mail; 
use Session;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Employee\Employees;
Use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HrmController;
use App\Models\Leave\LeaveApplication;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

use App\Notifications\AllNotification;
use Illuminate\Support\Facades\Notification;
/*use App\Http\Controllers\EventSourceController;*/
use App\Models\SchoolEvent;
  
class AuthController extends HrmController
{
    /**
     * Landing Page
     *
     * @return response()
     */
    public function index()
    {
        return view('auth.login');
    }  
      
    /**
     * Registration page (if any)
     *
     * @return response()
     */
    public function registration()
    {
        return view('auth.registration');
    }
      
    /** Method Aim : Login
     *  Params/Args : Array
     *  Type : Post     
     *  @return response()
    **/
    public function postLogin(Request $request)
    {        
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        /* Allowed ids: principal, vice-principal, executive-admin, super-admin, admin, hr, accountant respectively */
        $allowedUserIds = [19, 20, 64, 1, 2, 3, 30, 85];
        
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            
            $user = Auth::user();

            $emps = Employees::where('user_id', $user->id)->select('status')->first();
            if($emps){
                $active = $emps->status; 
            }else{
                $active = 1;
            }
            
            /*Get link ids for this user & store it to session */
            $role_access = $this->getRolesCapableLinks($user->roles[0]->id);
            Session::put('role_access', $role_access);
            
                if (in_array($user->id, $allowedUserIds) && 1==$active) {
                    if ($user->hasRole(SUPER_ADMIN_ROLE) || $user->hasRole(ADMIN_ROLE) || $user->hasRole(HR_ROLE) || $user->hasRole(VP_ROLE) || $user->hasRole(PRINCIPAL_ROLE) || $user->hasRole(ACC_ROLE) || $user->hasRole(EXAD_ROLE)) {
                        return redirect()->intended('dashboard')->withSuccess(trans('messages.success_login'));
                    } else {
                        return redirect("login")->withError(trans('messages.no_access'));
                    }
                } else {
                    return redirect("login")->withError(trans('messages.no_access'));
                }
        }
    
        return redirect("login")->withError(trans('messages.invalid_credential'));
    }
      
    /** Method Aim : Registration
     *  Params/Args : Array
     *  Type : Post     
     *  @return response()
    **/
    public function postRegistration(Request $request)
    {  
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
           
        $data = $request->all();
        $check = $this->create($data);
         
        return redirect("dashboard")->withSuccess(trans('messages.success_login'));
    }

    /** Method Aim : Laoding the forgot password page
     *  Params/Args : Nil
     *  Type : Post     
     *  @return response()
    **/
    public function forgotpassword()
    {
        return view('auth.forgotpassword');
    } 

    /** Method Aim : Forgot password
     *  Params/Args : Array
     *  Type : Post     
     *  @return response()
    **/
    public function postForgotpassword(Request $request)
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
        }
        catch(\Exception $e){ 
           $msg = trans('messages.errorCom');

        } 
        return back()->with('message', $msg);
    }

    /** Method Aim : Laoding the reset password page
     *  Params/Args : string
     *  Type : Post     
     *  @return response()
    **/
    public function showResetPasswordForm($token) { 
        $newtoken = explode('_mail_', $token);

        $existPassCheck = \DB::table('password_resets')
                              ->where([
                                'email' => $newtoken[1], 
                                'token' => $newtoken[0]
                              ])
                              ->first(); 
        if(!$existPassCheck){
        //if($existPassCheck){
           //$user = User::where('email', $newtoken[1])->whereNull('email_verified_at')->first();
            //if($user){
               //$user->email_verified_at = date('Y-m-d H:i:s');
               //$user->save();
            //}else{
               //return redirect('login')->with('success', trans('messages.lbl_verify_done')); 
            //}  
        //}else{
           return redirect('login')->with('error', trans('messages.link_expired'));
        }       

        return view('auth.resetpassword', ['token' => $token]);
    }

    /** Method Aim : Reset password
     *  Params/Args : Array
     *  Type : Post     
     *  @return response()
    **/
    public function submitResetPasswordForm(Request $request)
    {
            $request->validate([
              'email' => 'required|email|exists:users',
              'password' => 'required|string|min:6',
              'cpassword' => 'required'
            ]);
  
            $updatePassword = \DB::table('password_resets')
                              ->where([
                                'email' => $request->email, 
                                'token' => $request->token
                              ])
                              ->first();        
  
            if(!$updatePassword){
              return back()->withInput()->with('error', trans('messages.invalid_token'));
            }
  
            $user = \DB::table('users')->where('email', $request->email)
                      ->update(['password' => Hash::make($request->password)]);
 
            \DB::table('password_resets')->where(['email'=> $request->email])->delete();
  
            $msg = trans('messages.password_changed');
            return redirect('login')->with('message', $msg);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = \DB::table('users')->where('email', Auth::user()->email)
                    ->update(['password' => Hash::make($request->password)]);

        $msg = trans('messages.password_changed');
        return redirect()->back()->with('success', $msg);
    }
    
    public function resetEmployeePassword(Request $request)
    {
        try{
            $request->validate([
                'password' => ['required', 'string', 'min:6'],
            ]);

            $user = \DB::table('users')->where('id', $request->user_id_pass)
                        ->update(['password' => Hash::make($request->password)]);
            
            return redirect()->back()->with('success', trans('messages.emp_password_changed'));
        }
        catch(\Exception $e){
           return redirect()->back()->with('error', $e->getMessage());
        } 
    }

    
    /**
     * Dashboard page
     *
     * @return response()
     */
    public function dashboard()
    {
        $user = Auth::user();
        $now = Carbon::now();

        if(Auth::check()){
            
            /*Active Employee Count */
            $active_employees = Employees::where('status', 1)->count();

            /*Inactive Employee Count */
            $inactive_employees = Employees::where('status', 0)->count();

            /*Leave Approval Pending Count*/
            $leave_approval_pending = LeaveApplication::whereIn('status', [$this->leave_approval_status['applied'],
                                                                             $this->leave_approval_status['verified'],
                                                                             $this->leave_approval_status['hold'],
                                                                             $this->leave_approval_status['return']]
                                                                  )->count();
            /*Academic Year: Leave Count*/                        
            $academic_year_leaves = getAnnualLeaveCount(1, $this->academic_year);

            /* Audit/Logs/Activity data */
            $activities = \OwenIt\Auditing\Models\Audit::with('user')
                                        ->orderByDesc('created_at')
                                        ->limit(10);
            /*If Admin: Able to view all activities except the Super Admin*/
            if($user->hasRole(ADMIN_ROLE)) {
                $sadmin_role = Role::where('name', SUPER_ADMIN_ROLE)->first();
                $sadminid = User::role($sadmin_role)->first(); 
                $activities = $activities->whereNotIn('user_id', [$sadminid->id]);

            /*If Not Admin & Super Admin: Only able to view self activities*/
            }else if(!$user->hasRole(SUPER_ADMIN_ROLE)){
                $activities = $activities->where('user_id', $user->id);
            }

            $activities = $activities->get();

            foreach($activities as $eachactivity){
                $auditType = explode('\\', $eachactivity->auditable_type);                
                $eachactivity->module = implode(" ", preg_split('/(?=[A-Z])/', $auditType[count($auditType)-1], -1, PREG_SPLIT_NO_EMPTY));
                $timing = Carbon::parse($eachactivity->created_at);
                $diffInMinutes = $timing->diffInMinutes($now);
                $diffInHours = $timing->diffInHours($now);
                $eachactivity->hours = floor($diffInMinutes / 60);
                $eachactivity->minutes = $diffInMinutes % 60;
                $eachactivity->user = User::find($eachactivity->user_id);
            }  

            /*$strem = new EventSourceController(); */

            //Qid & Passport expiry employees            
            $qid_exp = getExpireDocData('QE');
            $pass_exp = getExpireDocData('PE');
            $qid_exp_count = ($qid_exp->isNotEmpty())?count($qid_exp):0;
            $pass_exp_count = ($pass_exp->isNotEmpty())?count($pass_exp):0;

            /*Dashboard card access */
            $access = DB::table('dashboard_settings')->select('role_id', 'card')->get();
            $curacc = [];
            if($access->isNotEmpty()){
                foreach($access as $eacacc){
                    $curacc[$eacacc->role_id] =  json_decode($eacacc->card);
                }
            }

            $userRole = Auth::user()->roles[0]->id;
            
            return view('home.dashboard', compact('active_employees', 'inactive_employees', 'leave_approval_pending', 'academic_year_leaves', 'activities', 'qid_exp_count', 'pass_exp_count', 'curacc', 'userRole'));
        }
        
        return redirect("login")->withError(trans('messages.no_access'));
    }

     /**
     * Profile page
     *
     * @return response()
     */
    public function profile()
    {
        if(Auth::check()){
            return view('home.profile');
        }
  
        return redirect("login")->withSuccess('Opps! You do not have access');
    }
    
    /** Method Aim : Create user while register
     *  Params/Args : Array
     *  Type : Get     
     *  @return response()
    **/
    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password'])
      ]);
    }
    
    /** Method Aim : Logout
     *  Params/Args : Nil
     *  Type : Get     
     *  @return response()
    **/
    public function logout() {
        
        $token = new \stdClass();
        $token->device_token = session('device_token');        
        
        /*Firebase Token handling*/
        $notif = new AllNotification();
        $device_token_remove = $notif->removeToken($token);

        Session::flush();
        Auth::logout();
  
        return Redirect('login');
    }
    public function logoutAllUsers()
    {
    DB::table('oauth_access_tokens')->update(['revoked' => true]);

    DB::table('oauth_refresh_tokens')->update(['revoked' => true]);

    session()->flush();

    return redirect('login')->with('success', 'All users have been logged out.');
    }
}
<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\HrmController;
use App\Notifications\AllNotification;
use Illuminate\Support\Facades\Notification;
use Session;
  
class CustomMessageController extends HrmController
{    
  
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home.custommessages');
    }
  
    /** 
     * Write code on Method
     *
     * @return response()
     */
    public function saveToken(Request $request)
    {        
        /*Firebase Token handling*/        
        $notif = new AllNotification();

        try{

            $device_token_save = $notif->saveToken($request); 
            if(1==$device_token_save){           
                Session::put('device_token', $request->device_token);
            }else{
                return response()->json([trans('messages.fcm_token_err')]);
            }

            return response()->json([trans('messages.fcm_token_succ')]);

        }catch (\Exception $e) {

            return response()->json([trans('messages.fcm_token_err')]);

        }        
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function sendNotification(Request $request)
    {        
        $notif = new AllNotification();
        $notif->sendPushNotifications($request, 3);
    }
}
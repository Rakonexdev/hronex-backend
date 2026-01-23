<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use App\Models\UserDeviceToken;
use App\Models\Notifications\Notifications;
use Log;


class AllNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }    

    /** 
     * Write code on Method
     *
     * @return response()
     */
    public function saveToken($request)
    {
        try
        {
            UserDeviceToken::where('user_id', auth()->user()->id)
                         ->where('device_token', $request->device_token)
                         ->delete();           

            $device_token = new UserDeviceToken();
            $device_token->user_id = auth()->user()->id;

            if(in_array(auth()->user()->id, [1,2])){
               $request->device_type = 'admin';
            }

            $device_token->device_type = $request->device_type;
            $device_token->device_token = $request->device_token;            
            $device_token->save();

            return 1;
            
            /*return response()->json(['token saved successfully.']);*/
        }
        catch(Exception $e){
            return 0;
        }
    }

    public function removeToken($request)
    {
        try
        {
            UserDeviceToken::where('user_id', auth()->user()->id)
                         ->where('device_token', $request->device_token)
                         ->delete();
            return 1;
        }
        catch(Exception $e){
            return 0;
        }
    }

    public function addnotifications($data)
    {
        try
        {                    

            Notifications::insert($data);
            return 1;           
            
        }
        catch(Exception $e){
            return 0;
        }
    }

    /*For push notification through fcm by cron job [ if any ]*/
    public function passNotification()
    {
        $data = NULL;

        $data = $this->fetchNotifyData('push');        
    }  
    
    public function fetchNotifyData($push=NULL)
    {
        $notifs = NULL;

        if(NULL != $push){

            $notifs = Notifications::whereNull('pushed_at')->get();
           
            if( 0 != count($notifs) ) {

                foreach ($notifs as $notification) {  
                    $dataa = new \stdClass();             
                    $dataa->body = $notification->data;
                    $dataa->title = $notification->title;
                    $dataa->title_date = $notification->title_date;
                    $dataa->link = $notification->link;
                    
                    $this->sendPushNotifications($dataa, $notification->notifiable_id);
                    
                    $notification->pushed_at = date('Y-m-d H:i:s');
                    $notification->save();

                } 
            }

        }else{

            $notifs = Notifications::whereNull('read_at')->get();
            return $notifs;

        }  
    }

    /*Method for send mobile/web notification through Firebase*/
    public function sendPushNotifications($request, $to_id=0)
    {        
        if(0 == $to_id)
            $firebaseToken = UserDeviceToken::whereNotNull('device_token')
                                              /*->where('device_type', '<>', 'admin')*/
                                              ->pluck('device_token')
                                              ->all();
        else
            $firebaseToken = UserDeviceToken::whereNotNull('device_token')
                                              ->where('user_id', $to_id)
                                              /*->where('device_type', '<>', 'admin')*/
                                              ->pluck('device_token')
                                              ->all();

        if(!isset($request->title_date)) $request->title_date = '';
        if(!isset($request->link)) $request->link = url('dashboard');
         
        $SERVER_API_KEY = 'AAAAilkvlcI:APA91bHGH-lyOrFQN2XH_J5l1GVW1ZpdoeV9pGok8achiOn9A0B46Bidf6YiJMCkBttFOIjSZjwi0krfVkOQt1xbWw8qY4nkSEoRZ4OI5cveJt4k89uNHcC3Yk13fyWn0Ou-KvVZely4';
  
        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $request->title,
                "body" => $request->body, 
            ],
            'data' => [
                'title_date' => $request->title_date,
                "link" => url($request->link)
            ]
        ];
        $dataString = json_encode($data);
    
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
               
        $respo = curl_exec($ch);

        /*dd($respo);*/
    }

    /*Method for send web notification through Firebase ( Now this applicable to leave request only )*/
    public function sendWebNotifications($request, $to_id=0)
    {        
        if(0 == $to_id)
            $firebaseToken = UserDeviceToken::whereNotNull('device_token')
                                              ->whereIn('device_type', ['admin', 'web'])
                                              ->pluck('device_token')
                                              ->all();
        else
            $firebaseToken = UserDeviceToken::whereNotNull('device_token')
                                              ->where('user_id', $to_id)
                                              ->whereIn('device_type', ['admin', 'web'])
                                              ->pluck('device_token')
                                              ->all();

        if(!isset($request->title_date)) $request->title_date = '';
        if(!isset($request->link)) $request->link = url('dashboard');
         
        $SERVER_API_KEY = 'AAAAilkvlcI:APA91bHGH-lyOrFQN2XH_J5l1GVW1ZpdoeV9pGok8achiOn9A0B46Bidf6YiJMCkBttFOIjSZjwi0krfVkOQt1xbWw8qY4nkSEoRZ4OI5cveJt4k89uNHcC3Yk13fyWn0Ou-KvVZely4';
  
        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $request->title,
                "body" => $request->body
            ],
            'data' => [
                "title_date" => $request->title_date,
                "link" => url($request->link)
            ]
        ];
        $dataString = json_encode($data);
    
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
               
        $respo = curl_exec($ch);

        /*dd($respo);*/
    }
}

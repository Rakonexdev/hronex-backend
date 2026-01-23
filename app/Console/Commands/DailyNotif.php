<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\HrmController;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AllNotification;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class DailyNotif extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dailynotif:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Daily Notification';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();        
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {        
        /*
           Write your database logic we bellow:
           Item::create(['name'=>'hello new']);
        */ 

        $storeAlerts = $this->storeAlerts();

        if(1!=$storeAlerts){
            \Log::info($storeAlerts);
            exit; 
        }

        try {
            
            $notif = new AllNotification();
            $notif->passNotification();

            \Log::info(trans('messages.cron_wrk_fine')); 

        }catch(\Exception $e){

            \Log::info($e->getMessage());

        }
    } 

    public function storeAlerts()
    {
        try { 

            $notif = new AllNotification();
            $hrmct = new HrmController();

            /*For probationary review after one month: notifications*/
            $probationary_pending = getDataAfterOneMonthOfJoining();

            if($probationary_pending->isNotEmpty()){

                /* Fetch Hr role user to notify */
                $hrRole = Role::where('name', HR_ROLE)->first();
                $user_id = User::role($hrRole)->first();
                $role_ids = $user_id->id;
                $to_email = $user_id->email;

                foreach($probationary_pending as $eachnt){  
                    $notifdata = [
                           'type' => $hrmct->notification_list[8],
                           'notifiable_type' => 'App\Models\Employee\Employees', 
                           'notifiable_id' => $role_ids, 
                           'title' => $hrmct->notification_list[8].': '.$eachnt->name.' '.$eachnt->lname.'(Joining: '.$eachnt->joiningdate.')',
                           'data' => trans('messages.warn_probat_pending')
                    ];
                    
                    Mail::send('emails.probationary-review-start-notify', ['employee' => $eachnt->name.' '.$eachnt->lname, 'joiningdate' => $eachnt->joiningdate ], function($message) use($to_email){
                            $message->to($to_email);
                            $message->subject(trans('messages.warn_probat_title'));
                    });

                    $notifs = $notif->addnotifications($notifdata);  
                }    
            }

            return 1;
        }catch (\Exception $e) {
            return $e->getMessage();
        }     
    }  

}

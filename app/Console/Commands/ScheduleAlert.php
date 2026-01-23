<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\HrmController;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AllNotification;

class ScheduleAlert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedulealert:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Alert Notification';

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

        /* $storeAlerts = $this->storeAlerts();

        if(1!=$storeAlerts){
            \Log::info($storeAlerts);
            exit; 
        } */

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

            /*For Passport/Qid expire[before 30 days] notifications*/
             $doc_expires = getExpireDocData();
            
            if($doc_expires->isNotEmpty()){
                foreach($doc_expires as $eachnt){ 
                    $pass = (null!=$eachnt->passportexpiry) ? $hrmct->notification_list[5].' Expiry:'.$eachnt->passportexpiry." " : '';
                    $qid = (null!=$eachnt->qidexpiry) ? $hrmct->notification_list[6].' Expiry:'.$eachnt->qidexpiry : '';
                    $expiry_data = $pass.' '.$qid;

                    $notifdata = [
                           'type' => $hrmct->notification_list[7],
                           'notifiable_type' => 'App\Models\Employee\Employees', 
                           'notifiable_id' => $eachnt->user_id, 
                           'title' => $eachnt->name.' '.$eachnt->lname, 
                           'data' => $expiry_data      
                    ]; 

                    $notifs = $notif->addnotifications($notifdata);  
                }            
            } 

            /*For profile un-complete[ 5 days after the account creation ] notifications*/
            $profile_uncomplete = getProfileUncompleteData();

            if($profile_uncomplete->isNotEmpty()){
                foreach($profile_uncomplete as $eachnt){  
                    $notifdata = [
                           'type' => $hrmct->notification_list[4],
                           'notifiable_type' => 'App\Models\Employee\Employees', 
                           'notifiable_id' => $eachnt->user_id, 
                           'title' => $eachnt->name.' '.$eachnt->lname, 
                           'data' => trans('messages.warn_prfl_incmplt')
                    ]; 

                    $notifs = $notif->addnotifications($notifdata);  
                }    
            }

            return 1;
        }catch (\Exception $e) {
            return $e->getMessage();
        }     
    }  

}

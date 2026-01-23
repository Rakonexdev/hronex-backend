<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\HrmController;
use App\Models\Employee\Attendance;

class AutoAttendance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'autoattendance:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto Attendance CheckOut';

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
        try {
            /*Fetch non-checkout attendance data */
            $curdate = date('Y-m-d');
            $latestAttendanceRecords = DB::table('attendances')
                ->select(DB::raw('MAX(id) as id'))                
                ->whereDate('created_at', '=', $curdate )
                ->groupBy('employee_id');

            $attendances = DB::table('attendances')
                ->whereIn('id', $latestAttendanceRecords)
                ->where('status', 'check-in')->get();

            if($attendances->isNotEmpty()){
                foreach($attendances as $eacatt){
                    $attendance = new Attendance();
                    $attendance->employee_id = $eacatt->employee_id;
                    $attendance->shift_id = $eacatt->shift_id;
                    $attendance->status = 'check-out';
                    $attendance->check_out = date('Y-m-d H:i:s');
                    $attendance->save(); 
                }
            }

            \Log::info('Auto Checkout: '.trans('messages.cron_wrk_fine')); 

        }catch(\Exception $e){
            \Log::info($e->getMessage());
        } 
    }
}

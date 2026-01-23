<?php

use Illuminate\Support\Facades\DB;
use Doctrine\DBAL\Driver\AbstractMySQLDriver;
use App\Models\Employee\Employees;
use App\Http\Controllers\Employee\LeaveApproveController;
use App\Models\Leave\LeaveApplication;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

function getStatus($status)
{
    if ($status == 1) {
        return 'Active';
    }else{
        return 'Deactive';
    }
}

function fileUpload($files = [], $path=NULL) {
    if(NULL==$path){
        $path = 'uploads';
    }

    $destinationPath = public_path($path);

    if (!file_exists($destinationPath)) {
        mkdir($destinationPath, 0777, true);
    }

    foreach ($files as $file) {
        $extension = $file->getClientOriginalExtension();
        $filename = time() . '_' . Str::random(10) . '.' . $extension;        

        if (File::exists(public_path($path.'/' . $filename))) {
            $random_num = rand(10000, 100000000);
            $filename = time() . '_' . Str::random(10) . '.' . $extension;
        }        

        $file->move($destinationPath, $filename);

        return $filename;
    }
}

function masterDropdown($table, $status_clm = 'active', $status = 1)
{
    $cached = Cache::remember('tables', 1440, function () {
        return DB::getDoctrineSchemaManager()->listTableNames();
    });

    if (in_array($table, $cached)) {
        return DB::table($table)->where($status_clm, $status)->get();
    }

    return null;
}

function degreeAttestationStatus($id) {
    switch ($id) {
        case 1:
            return 'Completely Attested';
            break;
        case 2:
            return 'Not Attested';
            break;
        case 3:
            return 'Attestation in Progress';
            break;
        default:
            return null;
            break;
    }
}

function leaveApplicationStatus($id) {
    switch ($id) {
        case 1:
            return 'Applied';
            break;
        case 2:
            return 'Approved';
            break;
        case 3:
            return 'Rejected';
            break;
        case 4:
            return 'Hold';
            break;
        default:
            return null;
            break;
    }
}

function getCountry($result, $value = null, $field = 'id') // $results Fields = ['id', 'phone_code', 'country_code', 'status']
{
    $validFields = ['id', 'phone_code', 'country_code', 'status'];

    if (!in_array($result, $validFields)) {
        throw new InvalidArgumentException("Invalid result field: $result");
    }

    try {
        $cached = Cache::remember('countries', 1440, function () {
            return DB::table('countries')->where('status', 1)->get();
        });

        foreach ($cached as $country) {
            if ($value) {
                if ($country->$field == $value) {
                    return $country->$result;
                }
            }
        }

        return null;

    } catch (\Exception $e) {
        Log::error('Error retrieving country: ' . $e->getMessage());
        return null;
    }
}

function academicYear($id)
{
    try {
        $academic_years = DB::table('academic_year')->where('active', 1)->get();

        foreach ($academic_years as $academic_year) {
            if ($id) {
                if ($academic_year->id == $id) {
                    return $academic_year->title;
                }
            }
        }

        return null;

    } catch (\Exception $e) {
        Log::error('Error retrieving academic year: ' . $e->getMessage());
        return null;
    }
}

function getNotificationsOld()
{
        $currentDate = Carbon::now();
        $expiryDate = $currentDate->addDays(30);
        $user = Auth::user();

        if ($user) {

            //$employee = Employees::where('user_id', $user->id)->first();
            $employee = Employees::with(['leaveApplication' => function ($query) use ($user) {
                
                $query->where('employee_id', $user->id);
            }])
            ->where(function ($query) use ($expiryDate) {
                $query->where('passportexpiry', '<=', $expiryDate)
                    ->orWhere('qidexpiry', '<=', $expiryDate);
            })->where('employee_id', $user->id)
            ->get();
            //dd($employee->passportexpiry);
            if ($employee) {
                return $employee;
            }
        }

        return collect();

}

function getExpireDocData($type=null)
{
    $notifs = [];
    $currentDate = date('Y-m-d'); 
    $expiryDate = Carbon::parse($currentDate)->addDays(30);
        
    $notifs = Employees::select('employee_id', 'user_id', 'name', 'lname', 'qidexpiry', 'passportexpiry')
                        ->where(function($query) use($currentDate, $expiryDate, $type){
                            if('QE'==$type){
                                //$query->whereBetween('qidexpiry', [$currentDate, $expiryDate]);
                                $query->where('qidexpiry', '<=', $expiryDate);
                            }else if('PE'==$type){
                                //$query->whereBetween('passportexpiry', [$currentDate, $expiryDate]);
                                $query->where('passportexpiry', '<=', $expiryDate);
                            }else{
                                //$query->whereBetween('passportexpiry', [$currentDate, $expiryDate])
                                //->orWhereBetween('qidexpiry', [$currentDate, $expiryDate]);
                                $query->where('passportexpiry', '<=', $expiryDate)
                                ->orWhere('qidexpiry', '<=', $expiryDate);
                            }
                        })
                        ->where('status', 1)->get();
    if($notifs->isNotEmpty()){
        foreach($notifs as $eachnt){
            if($eachnt->passportexpiry > $expiryDate){
              $eachnt->passportexpiry = null;   
            }
            if($eachnt->qidexpiry > $expiryDate){
              $eachnt->qidexpiry = null;   
            }
        }
    }
    
    return $notifs;
}

function getProfileUncompleteData()
{
    $notifs = [];
        
    $notifs = Employees::select('employee_id', 'user_id', 'name', 'lname')
                ->where(function($query){
                    $query->doesntHave('emergencyDetails')
                    ->orDoesntHave('healthInformation');
                }) 
                ->where('created_at', '<', Carbon::now()->subDays(5))
                ->where('status', 1)->get();

    return $notifs;
}

function employeeIdMaker($employee_id, $type='')
{
    $padded_emp_id = str_pad($employee_id, 5, '0', STR_PAD_LEFT);
    if(''!=$type){
        $val = $type.''.$padded_emp_id;
    }else{
        $val = $padded_emp_id;
    }
    return $val;
}

function enc_dec_data($value, $type)
{
    if('enc'==$type){
        /*$token = Str::random(64);*/ 
        $token = '9cWDfA8Ugh63P93F20sbHgc5rwZ1hkX49qmIv7Bg2l6K'; /*For static qr code */ 
        $key_data = $token.'-'.$value.'-'.$token;
        $data = base64_encode($key_data); 
    }else{
        $dec_data = base64_decode($value);
        $dec_data = explode("-", $dec_data);
        $data = $dec_data[1];  
    }

    return $data;
}

function enc_dec_data_new($value, $type)
{
    if('enc'==$type){
        $token = '9cW62Gxzp0tFd8'; /*For static qr code */ 
        $data = $token.'-'.$value.'-'.$token;
    }else{        
        $dec_data = explode("-", $value);
        $data = $dec_data[1];  
    }

    return $data;
}

function getAnnualLeaveCount($type=1, $fy=1)
{
    $al_count = 30;

    if(2!=$type){
        $al_data = DB::table('school_events')->where('event_type', 'Annual Leave')
                                    ->where('active', 1)
                                    ->whereNotIn('applicable_to', [2])
                                    ->where('academic_year', $fy)
                                    ->selectRaw('DATEDIFF(event_from, event_to) AS date_difference')
                                    ->groupBy('date_difference')
                                    ->get();
        $al_count = ($al_data->isNotEmpty())? abs($al_data[0]->date_difference)+1 : 30;

    }else{
        $al_data = DB::table('leave_types')->select('leave_days')
                                            ->where('id', 2)
                                            ->where('academic_year', $fy)
                                            ->where('active', 1)
                                            ->first();
        $al_count = ($al_data)? $al_data->leave_days : 30; 
    }

    return $al_count;
}

function getAllLeaveCount($leavetype, $fy='', $employee_id=0)
{
    $leave_count = 0;

    $leave_count = LeaveApplication::where('status', 6)
                        ->where('leave_type', $leavetype)
                        /* Leave type is not 'leave without pay' then check paid status is zero' */
                        ->when(11!=$leavetype, function ($query){
                            return $query->where('paid_status', 0);
                        })
                        ->when(''!=$fy, function ($query) use($fy){
                            return $query->where('academic_year', $fy);
                        })
                        ->when(0!=$employee_id, function ($query) use($employee_id){
                            return $query->where('employee_id', $employee_id);
                        })
                        ->sum('no_days');
    return $leave_count;
}

function isDataPresentInterval($timeFrom, $timeTo, $intervalFrom, $intervalTo) {
    if(0!=$timeFrom && 0!=$timeTo){
        return (strtotime(Carbon::parse($timeFrom)->format('H:i')) < strtotime($intervalTo) && 
                strtotime(Carbon::parse($timeTo)->format('H:i')) > strtotime($intervalFrom));
    }else if(0!=$timeFrom && 0==$timeTo){
        return (strtotime(Carbon::parse($timeFrom)->format('H:i')) < strtotime($intervalTo));
    }else if(0==$timeFrom && 0!=$timeTo){
        return (strtotime(Carbon::parse($timeTo)->format('H:i')) > strtotime($intervalFrom));
    }    
}

function departments()
{
    $departments = DB::table('departments')->where('active', 1)->get();
    return $departments;
}

function get_appraisal_type()
{
    $appraisal = DB::table('appraisal_type')->where('active',1)->pluck('id','type_name');
    return $appraisal;
}
function get_appraisal_applicable()
{
    $applicable = DB::table('appraisal_applicable')->where('status',1)->pluck('id','applicable');
    return $applicable;
}

function get_appraisal_data($type,$dept)
{
   $appriasal_data = DB::table('appraisal_data')->where('type',$type)->where('applicable_to',$dept)->get();
   return $appriasal_data;
}
function get_data_appraisal()
{
    $appriasal_data = DB::table('appraisal_data')->get();
    return $appriasal_data;
}
function get_shift_data()
{
    $shifts = DB::table('school_shift')->pluck('id','name');
    return $shifts;
}
function get_check_shift_time($id,$day)
{
    $time = DB::table('shift_assigns')->select('school_shift.start_time as start_time')
            ->where('employee_id', $id)
            ->whereDate('date_from', '<=', $day)
            ->whereDate('date_end', '>=', $day)
            ->leftjoin('school_shift','school_shift.id','=','shift_assigns.shift_id')
            ->orderBy('shift_assigns.id', 'DESC')
            ->first();
    if($time){
        return $time->start_time;
    }else{
        return 0;
    }
}
function get_app_user_id($web_user_id)
{
    $app_user_email = DB::table('user_associated_employee')
                    ->where('web_user_id', $web_user_id)->pluck('app_email')->first();

    $app_user_id = Employees::where('email', $app_user_email)->pluck('user_id')->first();

    return $app_user_id;
}
function get_leave_type()
{
    $leave_types =   DB::table('leave_types')->pluck('id','name');
    
    return $leave_types;
}
function getCheck_in($employee, $date)
{
    $check_in = $employee->attendance()
        ->whereDate('check_in', $date->format('Y-m-d'))
        ->first();
    return $check_in;
}
function get_leave_appliaction($employee, $date)
{
    $leave =  $employee->leaveApplication
            ->where(function ($query) use ($date) {
                $query->where('date_from', '<=', $date->format('Y-m-d'))
                    ->where('date_to', '>=', $date->format('Y-m-d'));
            })->where('employee_id',$employee->id)
            //->where('status',6)
            ->first();
    return $leave;
}
function getLeaveCountByYear($year, $employee_id, $leave_type, $leave_status)
{
    $count =LeaveApplication::where('status', $leave_status)
                            ->where('leave_type', $leave_type)
                            ->where('employee_id', $employee_id)
                            ->where(function ($query) use ($year) {
                                $query->whereBetween('date_from', [$year . '-01-01', $year . '-12-31'])
                                    ->orWhereBetween('date_to', [$year . '-01-01', $year . '-12-31']);
                            })->count();
    return $count;
}
function getDateDifference($inputDate)
{
    $inputDate = Carbon::parse($inputDate);

    // Get the 25th of the input month
    $twentyFifthOfMonth = $inputDate->copy()->day(25);

    // Check if the input date is greater than 25th of the input month
    if ($inputDate->gt($twentyFifthOfMonth)) {
        // Calculate the difference between the input date and 25th of the input month        
        $difference = $inputDate->diffInDays($twentyFifthOfMonth);
    } else {
        // If the input date is on or before 25th of the input month,
        // calculate the difference between the input date and 25th of the previous month
        $previousMonth = $inputDate->copy()->subMonthNoOverflow();
        $previousMonth->day(25);
        $difference = $inputDate->diffInDays($previousMonth);
    }

    return $difference;
}

function getDataAfterOneMonthOfJoining()
{
    $notifs = [];
    $currentDate = date('Y-m-d'); 
    $thirtyDaysBefore = Carbon::parse($currentDate)->subDays(30);
    $sixtyDaysBefore = Carbon::parse($currentDate)->subDays(60);
        
    $notifs = Employees::select('employee_id', 'user_id', 'name', 'lname', 'joiningdate')
                        ->where(function($query) use($sixtyDaysBefore, $thirtyDaysBefore){
                                $query->where('joiningdate', '<', $thirtyDaysBefore)
                                    ->where('joiningdate', '>', $sixtyDaysBefore);
                        })
                        ->where('is_conformed', 0)
                        ->where('status', 1)->get();
    return $notifs;
}

function approval_roles()
{
    return [
        HR_ROLE => 'HR',
        VP_ROLE => 'VP',
        PRINCIPAL_ROLE => 'Principal',
        EXAD_ROLE => 'Executive Admin',
    ];
}

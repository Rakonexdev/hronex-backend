<?php

namespace App\Http\Controllers\Api\Attendance;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Employee\Attendance;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee\Employees;
use App\Http\Controllers\HrmController;
use App\Models\Leave\LeaveApplication;
use DB;

use App\Notifications\AllNotification;
use Illuminate\Support\Facades\Notification;

class AttendanceController extends HrmController
{
    public function markAttendance(Request $request) 
    {

        try {

            $validator = Validator::make($request->all(), [
                'employee_id' => 'required|integer',
                'shift_id' => 'nullable|integer',
                'status' => 'required|in:check-in,check-out',
                'number' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }                       

            /*Get employee data[mainly:user_id] to compare the qr code data*/
            $emp_data = Employees::where('employee_id', $request->input('employee_id'))->first();

            /*Get user_id from the qr code*/
            $dec_data = enc_dec_data_new($request->input('number'), 'dec');

            /*Compare user_id[from qr code] with user_id[from employee table]*/
            if($dec_data != $emp_data->user_id){
                return response()->json(['error' => trans('messages.att_not_match') ], 422);
            }

            $attendance = new Attendance();
            $attendance->employee_id = $request->input('employee_id');
            $attendance->shift_id = $request->input('shift_id');



            /*Last stored attendance data*/
            $lastCheck = Attendance::where('employee_id', $request->input('employee_id'))                    
                    ->orderByDesc('created_at')
                    ->first();           

            /*If data exist & it was check in*/
            if ($lastCheck && 'check-in'==$lastCheck->status) {

                // Calculate time difference in minutes
                $timeDiffMinutes = Carbon::now()->diffInMinutes($lastCheck->check_in);
                if ($timeDiffMinutes < 5) {
                    return response()->json(['message' => trans('messages.att_chk_in_15') ], 422);
                }
                
                $msgs = trans('messages.att_check_out_msg');
                $chk_time = Carbon::now();

                $attendance->status = 'check-out';
                $attendance->check_out = $chk_time;
                $attendance->save();                           

            /*if data not exist OR exist & it was not check in*/
            }else{

                $msgs = trans('messages.att_check_in_msg');
                $chk_time = Carbon::now();

                $attendance->status = 'check-in';
                $attendance->check_in = $chk_time;
                $attendance->save();                             

            }

            /*Notification area*/
            $notif = new AllNotification();
            $body = "Time: ". $chk_time->format('H:i:s')." [ ".$chk_time->format('d-m-Y')." ] ";
            $to_id = $emp_data->user_id;

            /*Store notifications: Add notification data to table*/
            $notifdata['type'] = $this->notification_list[0]; /*trans('messages.atndnc_notif_title')*/ 
            $notifdata['notifiable_type'] = 'App\Models\Employee\Attendance';
            $notifdata['notifiable_id'] = $to_id;
            $notifdata['title'] = $msgs;
            $notifdata['data'] = $body;
            $notifdata['link'] = 'attendance';
            $notifs = $notif->addnotifications($notifdata); 

            /*Handle push notification to employee*/
            if(1==$notifs){
                $notif->passNotification();
            }
            
            $notif_data = new \stdClass();
            $notif_data->title = $msgs;
            $notif_data->body = "Time: ". $chk_time->format('H:i:s')." [ ".$chk_time->format('d-m-Y')." ] ";
            $send_notif = $notif->sendPushNotifications($notif_data, $to_id);

            return response()->json(['data' => $attendance , 'message' => $msgs ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function markAttendanceAll(Request $request) 
    { 
        $data = $request->all();
        $inputs = array();

        if(count(array_filter($data, 'is_array')) > 0) 
            $inputs=$data;
        else
            array_unshift($inputs, $data);

        try {

            DB::beginTransaction();

            // Validate & Insert data into tattendance table using a for loop
            foreach($inputs as $eachinput) {
                if('check-out'==$eachinput['status']){
                    $check_in = NULL;
                    $check_out = $eachinput['time'];
                    $msgs = trans('messages.att_check_out_msg');
                }else{
                    $check_out = NULL;
                    $check_in = $eachinput['time'];
                    $msgs = trans('messages.att_check_in_msg');
                }

                /*Check timing exist already : starts */
                $inptime = $eachinput['time'];
                $ioExist = Attendance::where('employee_id', $eachinput['employee_id'])
                                    ->whereDate('created_at', '<=', now())
                                    ->where(function ($query) use ($inptime) {
                                        $query->where('check_in', $inptime)
                                              ->orWhere('check_out', $inptime);
                                    })->first();
                if($ioExist){
                    continue;
                }
                /*Check timing exist already : ends */

                Attendance::create([
                    'employee_id' => $eachinput['employee_id'],
                    'shift_id' => 1,
                    'status' => $eachinput['status'],
                    'check_in' => $check_in,
                    'check_out' => $check_out
                ]);

                /*Notification area*/
                /*Get employee data[mainly:user_id] to compare the qr code data*/
                $emp_data = Employees::where('id', $eachinput['employee_id'])->first();

                $notif = new AllNotification();
                $body = "Time: ". Carbon::parse($eachinput['time'])->format('H:i:s')." [ ".Carbon::parse($eachinput['time'])->format('d-m-Y')." ] ";
                $to_id = $emp_data->user_id;

                /*Store notifications: Add notification data to table*/
                $notifdata['type'] = $this->notification_list[0]; 
                $notifdata['notifiable_type'] = 'App\Models\Employee\Attendance';
                $notifdata['notifiable_id'] = $to_id;
                $notifdata['title'] = $msgs;
                $notifdata['data'] = $body;
                $notifdata['link'] = 'attendance';
                //$notifdata['pushed_at'] = date('Y-m-d H:i:s');
                $notifs = $notif->addnotifications($notifdata);

                /*Handle push notification to employee*/
                /*if(1==$notifs){
                    $notif->passNotification();
                }
                
                $notif_data = new \stdClass();
                $notif_data->title = $msgs;
                $notif_data->body = $body;
                $send_notif = $notif->sendPushNotifications($notif_data, $to_id); */
            }

            DB::commit();
            return response()->json(['data' => true, 'message' => trans('messages.successO') ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    public function attendanceHistory($id)
    {
        try {
            $history = Attendance::where('employee_id', $id)->orderByDesc('created_at')->get();
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to retrieve attendance history'], 500);
        }

        if ($history->isEmpty()) {
            return response()->json(['message' => 'No attendance history found'], 404);
        }

        return response()->json(['data' => $history]);
    }

    public function generateRandomNumbers()
    {
        $numbers = [];
        for ($i=0; $i<20; $i++) {
            $numbers[] = mt_rand(100000, 999999);
        }

        $json = json_encode($numbers);

        $file = storage_path('app/random_numbers.json');
        file_put_contents($file, $json);

        if (file_exists($file)) {
            $json = file_get_contents($file);
            $numbers = json_decode($json, true);

            return $numbers;
        }
    }
    public function getstatus(Request $request)
    {   
        
        try{
            $validator = Validator::make($request->all(), [
                'employee_id' => 'required|integer',
                'date' => 'required',
                
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            $id = $request->employee_id;
            $date = $request->input('date');
            $formattedDate = date('Y-m-d', strtotime($date));
            $attendance = Attendance::where('employee_id', $id)
                ->where(function ($query) use ($formattedDate) {
                    $query->where(function ($query) use ($formattedDate) {
                        $query->whereDate('created_at', $formattedDate);
                        $query->WhereDate('check_in', $formattedDate)
                            ->orWhereDate('check_out', $formattedDate);
                    });
                })
                ->orderBy('created_at', 'desc')
                ->first();

            if ($attendance) {
                if ($attendance->check_in && !$attendance->check_out) {
                    $status = 'check_in';
                } elseif (!$attendance->check_in && $attendance->check_out) {
                    $status = 'check_out';
                } else {
                    $status = 'No entry found';
                }
            } else {
                $status = 'No attendance record found';
            }
        }catch (Exception $e) {
            return response()->json(['error' => 'Failed to retrieve attendance history'], 500);
        }

        
        return response()->json(['data' => $status]);
    }
    // public function attendancetrack(Request $request)
    // {
        


    //     $startDate  = $request->input('startDate');
    //     $employee_id = $request->input('employee_id');
    //     $currentMonth = Carbon::parse($startDate)->month;
    //     $lastMonth = Carbon::parse($startDate)->subMonth()->month;      
    //     $leaveApprovalStatus = $this->leave_approval_status['approved'];
    //     $startDate = Carbon::create(null, $lastMonth, 26, 0, 0, 0);
    //     $endDate = Carbon::create(null, $currentMonth, 25, 23, 59, 59);
        
    //     $status = $this->leave_approval_status['approved'];
        
    //     $acadmic_employees = Employees::where('employee_id', $employee_id)
    //         ->with(['attendance' => function ($query) use ($startDate, $endDate) {
    //             $query->whereBetween('check_in', [$startDate, $endDate]);
    //         }])
    //         ->select('employee_id', 'name', 'lname')
    //         ->get();
    
    //     $leave_application = LeaveApplication::where('status', $status)
    //         ->where('employee_id', $employee_id)
    //         ->where(function ($query) use ($startDate, $endDate) {
    //             $query->where(function ($query) use ($startDate, $endDate) {
    //                 $query->whereBetween('date_from', [$startDate, $endDate])
    //                     ->orWhereBetween('date_to', [$startDate, $endDate]);
    //             });
    //         })
    //         ->select('employee_id', 'leave_type', 'date_from', 'date_to', 'status')
    //         ->get();
    //         //dd($acadmic_employees);
   
    //     /*foreach ($acadmic_employees as $employee) {
    //         $attendanceData = $employee->attendance;
    //         $dateWiseAttendance = [];

    //         foreach ($attendanceData as $attendance) {
    //             $attendanceDate = $attendance->check_in ? date('Y-m-d', strtotime($attendance->check_in)) : date('Y-m-d', strtotime($attendance->check_out));

    //             if (!isset($dateWiseAttendance[$attendanceDate])) {
    //                 $dateWiseAttendance[$attendanceDate] = [
    //                     'date' => $attendanceDate,
    //                     'check_ins' => [],
    //                     'check_outs' => []
    //                 ];
    //             }

    //             if ($attendance->check_in) {
    //                 $dateWiseAttendance[$attendanceDate]['check_ins'][] = $attendance->check_in;
    //             }

    //             if ($attendance->check_out) {
    //                 $dateWiseAttendance[$attendanceDate]['check_outs'][] = $attendance->check_out;
    //             }
    //         }

    //         $employee->datewise = array_values($dateWiseAttendance);
            
    //     }*/
        
    //         $dateWiseAttendance = [];
            
    //         $current_date = $startDate;
    //         while ($current_date <= $endDate) {
    //             $current_date_str = $current_date->format('Y-m-d');
    //             $dayOfWeek = $current_date->format('l');
            
    //             $attendance = [
    //                 'date' => $current_date_str,
    //                 'check_ins' => [],
    //                 'check_outs' => [],
    //                 'type' => null,
    //                 'leave' => null
    //             ];
            
    //             if ($dayOfWeek === 'Friday') {
    //                 $attendance['type'] = 'friday';
    //             }
            
    //             $dateWiseAttendance[$current_date_str] = $attendance;
            
    //             $current_date->modify('+1 day');
    //         }

    //     foreach ($acadmic_employees as $employee) {
    //         $attendanceData = $employee->attendance;
    //         // $dateWiseAttendance = [];

    //         // $attendance['type'] = null;
    //         // $current_date = new \DateTime($startDate);
    //         // $end_date = new \DateTime($endDate);
            
    //         // while ($current_date <= $end_date) {
    //         //         $current_date_str = $current_date->format('Y-m-d');
    //         //         $dayOfWeek = $current_date->format('l');
              
    //         //         // $attendance = [
    //         //         //     'date' => $current_date_str,
    //         //         //     'check_ins' => [],
    //         //         //     'check_outs' => [],
    //         //         //     'type' => null
    //         //         // ];
                
    //         //         // if ($dayOfWeek === 'Friday') {
    //         //         //     //dd("test");
    //         //         //   // $dateWiseAttendance[$current_date_str]['type'] = 'weekend/friday';
    //         //         //   $attendance['type'] = 'friday';
    //         //         // }
    //         //         // $dateWiseAttendance[] = $attendance;
    //         //         // $current_date->modify('+1 day');
    //         //             $existingDate = null;
    //         //             foreach ($dateWiseAttendance as $existingAttendance) {
    //         //                 if ($existingAttendance['date'] === $current_date_str) {
    //         //                     $existingDate = $existingAttendance;
    //         //                     break;
    //         //                 }
    //         //             }
                
    //         //             if (!$existingDate) {
    //         //                 // Create a new attendance record for the date
    //         //                 $attendance = [
    //         //                     'date' => $current_date_str,
    //         //                     'check_ins' => [],
    //         //                     'check_outs' => [],
    //         //                     'type' => null
    //         //                 ];
                
    //         //                 if ($dayOfWeek === 'Friday') {
    //         //                     $attendanceType = 'friday';
    //         //                     $attendance['type'] = $attendanceType;
    //         //                 }
                
    //         //                 $dateWiseAttendance[] = $attendance;
    //         //             }
                
    //         //             $current_date->modify('+1 day');
    //         //         }

                
              
    //           // dd($dateWiseAttendance);
            
    //             // foreach ($attendanceData as $attendance) {
    //             //     $attendanceDate = $attendance->check_in ? date('Y-m-d', strtotime($attendance->check_in)) : date('Y-m-d', strtotime($attendance->check_out));
            
    //             //     if (!isset($dateWiseAttendance[$attendanceDate])) {
    //             //         $dateWiseAttendance[$attendanceDate] = [
    //             //             'date' => $attendanceDate,
    //             //             'check_ins' => [],
    //             //             'check_outs' => [],
    //             //             'type' => "checkin"
    //             //         ];
    //             //     }
            
    //             //     if ($attendance->check_in) {
    //             //         $dateWiseAttendance[$attendanceDate]['check_ins'][] = $attendance->check_in;
    //             //     }
            
    //             //     if ($attendance->check_out) {
    //             //         $dateWiseAttendance[$attendanceDate]['check_outs'][] = $attendance->check_out;
    //             //     }
    //             // }
    //         foreach ($attendanceData as $attendance) {
    //             $attendanceDate = $attendance->check_in ? date('Y-m-d', strtotime($attendance->check_in)) : date('Y-m-d', strtotime($attendance->check_out));
    //             // dd($attendanceDate);
    //             if (isset($dateWiseAttendance[$attendanceDate])) {
    //                 if ($attendance->check_in) {
    //                     $dateWiseAttendance[$attendanceDate]['check_ins'][] = $attendance->check_in;
    //                     $dateWiseAttendance[$attendanceDate]['type'] = 'checkin';
    //                 }
        
    //                 if ($attendance->check_out) {
    //                     $dateWiseAttendance[$attendanceDate]['check_outs'][] = $attendance->check_out;
    //                 }
    //             }
        
    //         // Check leave applications for each date
    //         foreach ($dateWiseAttendance as $date => &$attendance) {
    //             //$attendance['type'] = null; // Default type is null
        
    //             foreach ($leave_application as $leave) {
    //                 $leaveFrom = date('Y-m-d', strtotime($leave->date_from));
    //                 $leaveTo = date('Y-m-d', strtotime($leave->date_to));
        
    //                 if ($date >= $leaveFrom && $date <= $leaveTo) {
    //                     $attendance['type'] = "leave";
    //                     break;
    //                 }
    //             }
    //         }
        
    //         $dateWiseAttendance = array_values($dateWiseAttendance);
        
    //         usort($dateWiseAttendance, function ($a, $b) {
    //             return strtotime($a['date']) <=> strtotime($b['date']);
    //         });
        
    //         foreach ($dateWiseAttendance as &$attendance) {
    //             $attendance['check_ins'] = $attendance['check_ins'] ?: [];
    //             $attendance['check_outs'] = $attendance['check_outs'] ?: [];
    //             $attendance['leave'] = null;
        
    //             foreach ($leave_application as $leave) {
    //                 $leaveFrom = date('Y-m-d', strtotime($leave->date_from));
    //                 $leaveTo = date('Y-m-d', strtotime($leave->date_to));
        
    //                 if ($attendance['date'] >= $leaveFrom && $attendance['date'] <= $leaveTo) {
    //                     $attendance['leave'] = $leave;
        
    //                     if ($attendance['check_ins']) {
    //                         $attendance['type'] = 'half day leave';
    //                     } else {
    //                         $attendance['type'] = 'absent';
    //                     }
        
    //                     break;
    //                 }
    //             }
        
    //             if (!isset($attendance['type'])) {
    //                 $attendance['type'] = $attendance['check_ins'] ? 'present' : null;
    //             }
    //         }
        
    //         unset($attendance);
        
    //         // $employee->datewise = $dateWiseAttendance;
    //         foreach ($acadmic_employees as $key => $employee) {
    //             $employee->datewise = $dateWiseAttendance;
    //         }
    //     }
    //     }

    //     return response()->json(['data' => $acadmic_employees,'leave'=>$leave_application]);
    // }

 public function attendancetrackOld(Request $request)
    {
        


        $startDate  = $request->input('startDate');
        $employee_id = $request->input('employee_id');
        $currentMonth = Carbon::parse($startDate)->month;
        $lastMonth = Carbon::parse($startDate)->subMonth()->month;      
        $leaveApprovalStatus = $this->leave_approval_status['approved'];
        $startDate = Carbon::create(null, $lastMonth, 26, 0, 0, 0);
        $endDate = Carbon::create(null, $currentMonth, 25, 23, 59, 59);
        
        $status = $this->leave_approval_status['approved'];
        
        $acadmic_employees = Employees::where('employee_id', $employee_id)
            ->with(['attendance' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('check_in', [$startDate, $endDate]);
                $query->orWhereBetween('check_out', [$startDate, $endDate]);
            }])
            ->select('employee_id', 'name', 'lname')
            ->get();
    
        $leave_application = LeaveApplication::where('status', $status)
            ->where('employee_id', $employee_id)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->where(function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('date_from', [$startDate, $endDate])
                        ->orWhereBetween('date_to', [$startDate, $endDate]);
                });
            })
            ->select('employee_id', 'leave_type', 'date_from', 'date_to', 'status')
            ->get();
            //dd($acadmic_employees);
   
        
        
            $dateWiseAttendance = [];
            
            $current_date = $startDate;
            while ($current_date <= $endDate) {
                $current_date_str = $current_date->format('Y-m-d');
                $dayOfWeek = $current_date->format('l');
            
                $attendance = [
                    'date' => $current_date_str,
                    'check_ins' => [],
                    'check_outs' => [],
                    'type' => null,
                    'leave' => null
                ];
                $dateWiseAttendance[$current_date_str] = $attendance;
                if ($dayOfWeek === 'Friday') {
                    // $attendance['type'] = 'friday';
                    $dateWiseAttendance[$current_date_str]['type'] = 'friday';
                }
            
                
            
                $current_date->modify('+1 day');
            }

            foreach ($acadmic_employees as $employee) {
                $attendanceData = $employee->attendance;
            
                foreach ($attendanceData as $attendance) {
                    $attendanceDate = $attendance->check_in ? date('Y-m-d', strtotime($attendance->check_in)) : date('Y-m-d', strtotime($attendance->check_out));
                    if (isset($dateWiseAttendance[$attendanceDate])) {
                        if ($attendance->check_in) {
                            $dateWiseAttendance[$attendanceDate]['check_ins'][] = $attendance->check_in;
                            $dateWiseAttendance[$attendanceDate]['type'] = 'checkin';
                            
                        }
            
                        if ($attendance->check_out) {
                            $dateWiseAttendance[$attendanceDate]['check_outs'][] = $attendance->check_out;
                        }
                        // $dateWiseAttendance[$attendanceDate]['type'] = 'checkin and checkout';
                    }
                    else {
                        // If the date is not present, initialize it with the attendance details
                        $dateWiseAttendance[$attendanceDate] = [
                            'date' => $attendanceDate,
                            'check_ins' => $attendance->check_in ? [$attendance->check_in] : [],
                            'check_outs' => $attendance->check_out ? [$attendance->check_out] : [],
                            'type' => 'checkin_and_checkout',
                            'leave' => null
                        ];
                    }
                }
                    // Check leave applications for each date
                    foreach ($dateWiseAttendance as $date => &$attendance) {
                        //$attendance['type'] = null; // Default type is null
                
                        foreach ($leave_application as $leave) {
                            $leaveFrom = date('Y-m-d', strtotime($leave->date_from));
                            $leaveTo = date('Y-m-d', strtotime($leave->date_to));
                
                            if ($date >= $leaveFrom && $date <= $leaveTo) {
                                $attendance['type'] = "leave";
                                break;
                            }
                        }
                    }
            
                    $dateWiseAttendance = array_values($dateWiseAttendance);
            
                    usort($dateWiseAttendance, function ($a, $b) {
                        return strtotime($a['date']) <=> strtotime($b['date']);
                    });
            
                    foreach ($dateWiseAttendance as &$attendance) {
                        $attendance['check_ins'] = $attendance['check_ins'] ?: [];
                        $attendance['check_outs'] = $attendance['check_outs'] ?: [];
                        $attendance['leave'] = null;
                
                        foreach ($leave_application as $leave) {
                            $leaveFrom = date('Y-m-d', strtotime($leave->date_from));
                            $leaveTo = date('Y-m-d', strtotime($leave->date_to));
                
                            if ($attendance['date'] >= $leaveFrom && $attendance['date'] <= $leaveTo) {
                                $attendance['leave'] = $leave;
                
                                if ($attendance['check_ins']) {
                                    $attendance['type'] = 'half day leave';
                                } else {
                                    $attendance['type'] = 'absent';
                                }
                
                                break;
                            }
                        }
                
                        if (!isset($attendance['type'])) {
                            $attendance['type'] = $attendance['check_ins'] ? 'present' : null;
                        }
                    }
            
                    unset($attendance);
            
                    // $employee->datewise = $dateWiseAttendance;
                    foreach ($acadmic_employees as $key => $employee) {
                        $employee->datewise = $dateWiseAttendance;
                    }
               // }
            }
        //}
        return response()->json(['data' => $acadmic_employees,'leave'=>$leave_application]);
    }

    public function markAttendanceOld(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'employee_id' => 'required|integer',
                'shift_id' => 'nullable|integer',
                'status' => 'required|in:check-in,check-out',
                'number' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $file = storage_path('app/random_numbers.json');
            if (file_exists($file)) {
                $json = file_get_contents($file);
                $numbers = json_decode($json, true);
                if (!in_array($request->input('number'), $numbers)) {
                    return response()->json(['error' => 'Invalid number'], 422);
                }
            } else {
                return response()->json(['error' => 'Random number file not found'], 500);
            }           

            $attendance = new Attendance();
            $attendance->employee_id = $request->input('employee_id');
            $attendance->shift_id = $request->input('shift_id');
            $attendance->status = $request->input('status');

            if ($request->input('status') == 'check-in') {
                $attendance->check_in = Carbon::now();
            }

            if ($request->input('status') == 'check-out') {
                $lastCheckIn = Attendance::where('employee_id', $request->input('employee_id'))
                    ->where('status', 'check-in')
                    ->orderByDesc('created_at')
                    ->first();

                if (!$lastCheckIn) {
                    return response()->json(['error' => 'No check-in details found for this employee'], 422);
                }

                // Calculate time difference in minutes
                $timeDiffMinutes = Carbon::now()->diffInMinutes($lastCheckIn->check_in);

                if ($timeDiffMinutes < 15) {
                    return response()->json(['message' => 'Your Login time was less than 15 minutes.'], 422);
                }

                $lastCheckIn->check_in = $lastCheckIn->check_in;
                $lastCheckIn->check_out = Carbon::now();

                $lastCheckIn->status = 'check-out';
                $lastCheckIn->save();
                return response()->json(['data' => $lastCheckIn , 'message' => 'Attendance check out marked successfully']);
            }else {
                $attendance->save();
                return response()->json(['data' => $attendance , 'message' => 'Attendance check in marked successfully']);
            }

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function attendancetrack(Request $request)
    {
        try {
            $att_data = [];
            $datas = [];
            $check = NULL;
            $employee_id = $request->input('employee_id');
            
            if($request['startDate']){
                $currentYear = Carbon::parse($request['startDate'])->year;
                $currentMonth = Carbon::parse($request['startDate'])->month;
                $endDate = Carbon::create($currentYear, $currentMonth, 25, 23, 59, 59);
                $endDate = $endDate->endOfMonth();
                $startDate  = Carbon::create($currentYear, $currentMonth, 1, 0, 0, 0);;
            }else{
                $endDate = Carbon::now();
                $startDate  = Carbon::now()->startOfMonth();
            }
            
            //$startDate  = ($request['startDate']) ? $request['startDate'] : date('Y-m-d');
            /* $currentDay = Carbon::parse($startDate)->day;
            $currentMonth = Carbon::parse($startDate)->month;
            $currentYear = Carbon::parse($startDate)->year;
            if(25 >= $currentDay){
                $otherMonth = Carbon::parse($startDate)->subMonthsNoOverflow(1)->month;
                $otherYear = Carbon::parse($startDate)->subMonth()->year;
                $startDate = Carbon::create($otherYear, $otherMonth, 26, 0, 0, 0);
                $endDate = Carbon::create($currentYear, $currentMonth, 25, 23, 59, 59);
            }else{
                $otherMonth = Carbon::parse($startDate)->addMonthsNoOverflow(1)->month; 
                $otherYear = Carbon::parse($startDate)->addMonth()->year; 
                $startDate = Carbon::create($currentYear, $currentMonth, 26, 0, 0, 0);
                $endDate = Carbon::create($otherYear, $otherMonth, 25, 23, 59, 59);
            } */

            /*Start date to end date loop */
            while ($startDate->lte($endDate)) {
                $att_data['date'] = $startDate->toDateString();

                /*Fetch attendance for each day */
                $attendance_data = Attendance::where('employee_id', $employee_id)
                                            ->where(function ($subquery) use ($startDate, $endDate) {
                                                    $subquery->whereDate('check_in', $startDate)
                                                        ->orWhereDate('check_out', $startDate);
                                            })->get();
                
                if($attendance_data->isNotEmpty()){
                    foreach($attendance_data as $att){
                        if('check-in' == $att->status){
                            $check['in'][] = Carbon::parse($att->check_in)->format('H:i');
                        }else{
                            $check['out'][] = Carbon::parse($att->check_out)->format('H:i');
                        }
                    } 
                }

                $att_data['attendance'] = $check;

                /*Weekend detector for app */
                if (in_array(Carbon::parse($startDate)->format('l'), ['Friday', 'Saturday'])){
                    $att_data['type'] = 'weekend';
                }else{
                    $att_data['type'] = '';
                }

                /*Leave related data */
                $leaveRecords = LeaveApplication::where('employee_id', $employee_id)
                                            ->whereDate('date_from', '<=', $startDate)
                                            ->whereDate('date_to', '>=', $startDate)
                                        ->where('status', $this->leave_approval_status['approved'])
                                        ->get();
                $att_data['leave'] = $leaveRecords->isNotEmpty() ? 1 : 0;

                $datas[] = $att_data;
                $check = NULL;
                $att_data['leave'] = 0;
                $startDate->addDay();
            }

            return response()->json(['data' => $datas], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
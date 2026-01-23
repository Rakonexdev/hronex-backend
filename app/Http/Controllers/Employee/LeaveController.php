<?php

namespace App\Http\Controllers\Employee;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Leave\LeaveType;
use App\Models\Employee\Employees;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Leave\LeaveApplication;
use App\Http\Controllers\HrmController;
use App\Models\Leave\LeaveApplicationStatus;
use Illuminate\Support\Facades\Notification;

class LeaveController extends HrmController
{
    public function index()
    {
        return view('leave.leave_apply');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // $role = Role::create(['name' => 'Vp']);
        // $role = Role::create(['name' => 'Principal']);

        $validatedData = $request->validate([
            'employee_id' => 'required',
            'employee_name' => 'required',
            'leave_type' => 'required',
            'date_from' => 'required',
            'date_to' => 'required',
            'time_from' => 'required',
            'time_end' => 'required',
            'no_days' => 'required',
            'reason' => 'required',
        ]);

        $employee = Employees::find($request->employee_id);
        if($employee->department == 1) {
            // $user = User::find($request->employee_id);
            // $user->assignRole(VP_ROLE);
            // $role_ids = User::role(VP_ROLE)->pluck('id')->toArray();
            $vpRole = Role::where('name', VP_ROLE)->first();
                // $role_ids = User::role($vpRole)->pluck('id')->toArray();
            $user_id = User::role($vpRole)->first();
            $role_ids = $user_id->id;
        }

        if($employee->department == 2) {
            $hrRole = Role::where('name', HR_ROLE)->first();
            // $role_ids = User::role($hrRole)->pluck('id')->toArray();
            $user_id = User::role($hrRole)->first();
            $role_ids = $user_id->id;
            // $role_ids = User::role(HR_ROLE)->pluck('id')->toArray();
        }
        // return $role_ids;
        // array_push($role_ids, 1);
        $filename = null;
        if ($request->hasFile('attachment')) {
            $filename = fileUpload([$request->file('attachment')]);
        }
        $user = auth()->user();
        $leave = LeaveApplication::create($validatedData + ['attachment' => $filename, 'created_by' => $user->id, 'updated_by' => $user->id]);


        $leave_status = LeaveApplicationStatus::create([
            'leave_id' => $leave->id,
            'applier_id' => $leave->employee_id,
            'approver_id' => $role_ids,
            'leave_status' => 1,
            'assigned_to_role' =>1,
            'assigned_to_id' => 1,
            'comment'=> 'no comment',
        ]);

        $leave_type = LeaveType::findOrFail($leave->leave_type);

        $user = Auth::user();
        $hrRole = Role::where('name', 'Hr')->first();
        $vpRole = Role::where('name', 'Vp')->first();

        // if ($hrRole && $leave_type->applicable_to == '1') {
        //     $notification = Notification::create('New leave application submitted by '.$leave->employee_name);
        //     $topic = new Topic($hrRole->name);
        //     $message = CloudMessage::withTarget('topic', $topic)->withNotification($notification);
        //     $messaging = app('firebase.messaging');
        //     $messaging->send($message);
        // }

        // if ($vpRole && $leave_type->applicable_to == '2') {
        //     $notification = Notification::create('New leave application submitted by '.$leave->employee_name);
        //     $topic = new Topic($hrRole->name);
        //     $message = CloudMessage::withTarget('topic', $topic)->withNotification($notification);
        //     $messaging = app('firebase.messaging');
        //     $messaging->send($message);
        // }

        return redirect()->back()->with('success', 'Leave application submitted successfully.');
    }

    public function takeSickLeave(Employees $employee, Request $request)
    {

        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'medical_certificate' => 'required|file',
        ]);

        // Check if the employee is eligible for sick leave
        if (!$employee->takeSickLeave($request->start_date, $request->end_date)) {
            return redirect()->back()->withErrors(['You are not eligible for sick leave.']);
        }

        $fileName = $request->file('medical_certificate')->store('medical-certificates');
        $sickLeave = $employee->sickLeaves()->latest()->first();
        $sickLeave->update(['medical_certificate' => $fileName]);

        return redirect()->back()->with('success', 'Your sick leave request has been submitted.');
    }

}
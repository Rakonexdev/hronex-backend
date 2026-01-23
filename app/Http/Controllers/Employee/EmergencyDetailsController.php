<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HrmController;
use App\Models\Employee\EmergencyDetails;
use Illuminate\Support\Facades\Validator;

class EmergencyDetailsController extends HrmController
{
    public function index()
    {
        return redirect('employees');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        if (!Auth::user()->hasRole(HR_ROLE) && !Auth::user()->hasRole(SUPER_ADMIN_ROLE)) {
            return redirect('employees')->with('error', 'Health Information is only accessible to HR & SA.');
        }
        $data = Validator::make($request->all(), EmergencyDetails::$rules);
        if ($data->fails()) {
            return redirect()->back()->withErrors($data)->withInput();
        }

        $eed = new EmergencyDetails;
        $eed->user_id = $request->user_id;
        $eed->emergency_primary_name = $request->emergency_primary_name .' '. $request->emergency_primary_lname;
        $eed->relationship_primary = $request->relationship_primary;
        $eed->emergency_primary_contact = $request->emergency_primary_contact;
        $eed->emergency_secondary_name = $request->emergency_secondary_name .' '. $request->emergency_secondary_lname;
        $eed->relationship_secondary = $request->relationship_secondary;
        $eed->emergency_secondary_contact = $request->emergency_secondary_contact;
        $eed->comment = $request->comment;
        $eed->save();
        return redirect('employees')->with('success', trans('messages.successC'));
    }

    public function show($id)
    {
        $user_id = $id;
        return view('employee.emergency_details', compact('user_id'));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        if (!Auth::user()->hasRole(HR_ROLE) && !Auth::user()->hasRole(SUPER_ADMIN_ROLE)) {
            return redirect('employees')->with('error', 'Health Information is only accessible to HR & SA.');
        }
        $validated_data = $request->validate(EmergencyDetails::$rules);

        try {
            // Check if health information record already exists for the user
            $eed = EmergencyDetails::where('user_id', $request->user_id)->first();

            if (!$eed) {
                // If no existing record, create a new one
                $this->store($request);
            }

            $health_info = EmergencyDetails::where('user_id', $id)->firstOrFail();
            $health_info->update($validated_data);

            return redirect()->back()->with('success', trans('messages.successU'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', trans('messages.errorU'));
        }
    }

    public function destroy($id)
    {
        //
    }
}
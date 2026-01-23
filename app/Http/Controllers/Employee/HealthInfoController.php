<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HrmController;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee\HealthInformation;
use App\Models\Employee\EmployeePayrollInformation;
use App\Models\Employee\EmployeeFiles;

class HealthInfoController extends HrmController
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
            return redirect()->back()->with('error', 'Health Information is only accessible to HR & SA.');
        }
        $hmc_card_atch_filename = null;
        $health_insurance_atch_filename = null;

        $validate = $request->all();
        $data = Validator::make($validate, HealthInformation::$rules);

        if ($data->fails()) {
            return redirect()->back()->withErrors($data)->withInput();
        }
        if (!$request->user_id) {
            return redirect('employees')->with('error', 'User Id not set');
        }

        $ehi = new HealthInformation;
        $ehi->user_id = $request->user_id;
        $ehi->hmc_card_no = $request->hmc_card_no;
        $ehi->hmc_card_atch = $request->hmc_card_atch;
        $ehi->health_insurance_status = $request->health_insurance_status;
        $ehi->health_insurance_atch = $request->health_insurance_atch;
        $ehi->health_insurance_name = $request->health_insurance_name;
        $ehi->blood_group = $request->blood_group;
        $ehi->medical_ailment_physical = $request->medical_ailment_physical;

        // Convert physical_details to a string
        $physical_details = is_array($request->physical_details) ? serialize($request->physical_details) : '';
        $ehi->physical_details = $physical_details;

        $ehi->medical_ailment_mental = $request->medical_ailment_mental;

        $mental_details = array_filter($request->mental_details);
        $mental_details = array_filter($mental_details, function($value) {
            return $value !== "Add more details";
        });
        $ehi->mental_details = serialize($mental_details);

        $ehi->medication_details = $request->medication_details;
        $ehi->save();

        return redirect('employees')->with('success', trans('messages.successC'));
    }

    public function show($id)
    {
        if (!Auth::user()->hasRole(HR_ROLE) && !Auth::user()->hasRole(SUPER_ADMIN_ROLE)) {
            return redirect()->back()->with('success', 'Health Information is only accessible to HR & SA.');
        }
        $user_id = $id;
        return view('employee.health_information', compact('user_id'));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        // return $request;
        if (!Auth::user()->hasRole(HR_ROLE) && !Auth::user()->hasRole(SUPER_ADMIN_ROLE)) {
            return redirect()->back()->with('error', 'Health Information is only accessible to HR & SA.');
        }
        $validated_data = $request->validate(HealthInformation::$rules);

        try {
            // Check if health information record already exists for the user
            $ehi = HealthInformation::where('user_id', $request->user_id)->first();

            if (!$ehi) {
                // If no existing record, create a new one
                $this->store($request);
            }

            $health_info = HealthInformation::where('user_id', $id)->firstOrFail();
            $validated_data['mental_details'] = serialize($request->mental_details);
            $validated_data['physical_details'] = serialize($request->physical_details);
            $health_info->update($validated_data);

            return redirect()->back()->with('success', trans('messages.successU'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        //
    }
}
<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\HrmController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee\EmployeePayrollInformation;

class PayrollInfoController extends HrmController
{
    public function index()
    {
        return redirect('employees');
    }

    public function create()
    {
        //
    }

    public function getEmployee($id)
    {
        # code...
    }

    public function store(Request $request)
    {
        $data = Validator::make($request->all(), EmployeePayrollInformation::$rules);

        if ($data->fails()) {
            return redirect()->back()->withErrors($data)->withInput();
        }
        $epi = new EmployeePayrollInformation;
        $epi->user_id = $request->user_id;
        $epi->basic_salary = $request->basic_salary;
        $epi->accomodation_allowance = $request->accomodation_allowance;
        $epi->transport_allowance = $request->transport_allowance;
        $epi->continuous_allowance = $request->continuous_allowance;
        $epi->temp_allowance = $request->temp_allowance;
        $epi->other_allowance = $request->other_allowance;
        $epi->gross_total = $request->gross_total;
        $epi->bank_name = $request->bank_name;
        $epi->account_no = $request->account_no;
        $epi->iban_no = $request->iban_no;
        $epi->salary_effective_from = $request->salary_effective_from;
        $epi->bank_docs = $request->bank_docs ? fileUpload([$request->bank_docs]) : '';
        $epi->save();
        return redirect('employees');
    }

    public function show($id)
    {
        $user_id = $id;
        return view('employee.payroll_informations', compact('user_id'));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate(EmployeePayrollInformation::$rules);

        try {
            $payroll = EmployeePayrollInformation::where('user_id', $id)->firstOrFail();
            $payroll->update($validatedData);

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
<?php

namespace App\Http\Controllers\Api\Payroll;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Employee\EmployeePayrollInformation;
use Illuminate\Http\Request;
use App\Models\Employee\EmployeeFiles;

class PayrollController extends Controller
{
    public function store(Request $request)
    {
        try {
            $filename = null;
            $filedata = NULL;
            $fls = NULL;

            if ($request->hasFile('bank_docs')) {
                $filename = fileUpload([$request->file('bank_docs')], 'uploads/employees/files');
                $fls[] = $filename;
            }
            /*$employeePayroll = EmployeePayrollInformation::firstOrCreate(
                ['user_id' => $request->input('user_id')],
                [
                    'bank_name' => $request->input('bank_name'),
                    'account_no' => $request->input('account_no'),
                    'iban_no' => $request->input('iban_no'),
                    'bank_docs' => $filename,
                ]
            );*/
            $employeePayroll = EmployeePayrollInformation::where('user_id', $request->input('user_id'))
                                                           ->orderBy('id', 'desc')->first();
            if (!$employeePayroll) {
                $employeePayroll = new EmployeePayrollInformation();
                $employeePayroll->user_id = $request->input('user_id');
            }
            if ($request->has('bank_name')) {
                $employeePayroll->bank_name = $request->input('bank_name');
            }
            if ($request->has('account_no')) {
                $employeePayroll->account_no = $request->input('account_no');
            }
            if ($request->has('iban_no')) {
                $employeePayroll->iban_no = $request->input('iban_no');
            }
            $employeePayroll->bank_docs = $filename;
            $employeePayroll->save();

            /*Store file data to employee file table*/
            if(NULL != $fls){                
                foreach($fls as $index => $eachfl){                    
                    $filedata[] = [
                                "user_id" => $request->user_id,
                                "file_data" => json_encode([$eachfl]),
                                "file_type" => 'Bank Doc',
                                "file_path" => 'uploads/employees/files',
                                "created_by" => Auth::user()->id,
                                "updated_by" => Auth::user()->id
                            ];
                }

                // Save the file data to the employee files table
                if(NULL != $filedata)
                    $formData = EmployeeFiles::insert($filedata);
            }


            return response()->json([
                'data' => $employeePayroll,
                'path' => 'uploads/employees/files',
                'message' => 'Data saved successfully.',
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'An error occurred while saving data to the database.',
            ], 500);
        }
    }

    public function show($user_id)
    {
        try {
            $employeePayroll = EmployeePayrollInformation::where('user_id', $user_id)->orderBy('id', 'desc')->first();

            if (!$employeePayroll) {
                return response()->json([
                    'error' => true,
                    'message' => 'Data not found.',
                ], 404);
            }

            return response()->json([
                'data' => $employeePayroll,
                'message' => 'Data retrieved successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'An error occurred while retrieving data from the database.',
            ], 500);
        }
    }
}
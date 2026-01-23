<?php

namespace App\Http\Controllers\Api\Employee;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee\HealthInformation;
use App\Models\Employee\EmployeeFiles;

class HealthInfoController extends Controller
{
    public function store(Request $request)
    {
        $hmc_card_atch_filename = null;
        $health_insurance_atch_filename = null;
        $filedata = NULL;
        $fls = NULL;

        $validate = $request->all();
        $validator = Validator::make($validate, HealthInformation::$rules);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        try {
            // Check if health information record already exists for the user
            $ehi = HealthInformation::where('user_id', $request->user_id)->first();

            if (!$ehi) {
                // If no existing record, create a new one
                $ehi = new HealthInformation;
                $ehi->user_id = $request->user_id;
            }


            if ($request->hasFile('hmc_card_atch')) {
                $hmc_card_atch_filename = fileUpload([$request->file('hmc_card_atch')], 'uploads/employees/files');
                $fls[] = $hmc_card_atch_filename;
            }

            if ($request->hasFile('health_insurance_atch')) {
                $health_insurance_atch_filename = fileUpload([$request->file('health_insurance_atch')], 'uploads/employees/files');
                $fls[] = $health_insurance_atch_filename;
            }

            // Update the health information fields
            $ehi->hmc_card_no = $request->hmc_card_no;
            $ehi->hmc_card_atch = $hmc_card_atch_filename;
            $ehi->health_insurance_status = $request->health_insurance_status;
            $ehi->health_insurance_atch = $health_insurance_atch_filename;
            $ehi->health_insurance_name = $request->health_insurance_name;
            $ehi->blood_group = $request->blood_group;
            $ehi->medical_ailment_physical = $request->medical_ailment_physical;
          
            $physical_details = json_decode($request->physical_details);          
    
            if (is_array($physical_details)) {
                $physical_details = array_filter($physical_details, function ($value) {
                    return $value !== "Add more details";
                });
                $ehi->physical_details = serialize($physical_details);
            } else {
                $ehi->physical_details = null;
            }

            $ehi->medical_ailment_mental = $request->medical_ailment_mental;

            $mental_details = json_decode($request->mental_details);
            if (is_array($mental_details)) {
                $mental_details = array_filter($mental_details, function ($value) {
                    return $value !== "Add more details";
                });
                $ehi->mental_details = serialize($mental_details);
            } else {
                $ehi->mental_details = null;
            }

            $ehi->medication_details = $request->medication_details;
            $ehi->save();

            if ($ehi->mental_details) {
                $ehi->mental_details = unserialize($ehi->mental_details);
            }

            if ($ehi->physical_details) {
                $ehi->physical_details = unserialize($ehi->physical_details);
            }

            /*Store file data to employee file table*/
            if(NULL != $fls){
                $key = ['Hmc Card', 'Health Insurance'];
                foreach($fls as $index => $eachfl){                    
                    $filedata[] = [
                                "user_id" => $request->user_id,
                                "file_data" => json_encode([$eachfl]),
                                "file_type" => $key[$index],
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
                'success' => true,
                'file_path' => 'uploads/employees/files',
                'message' => 'Employee health information stored successfully.',
                'data' => $ehi
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Failed to store employee health information. ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $ehi = HealthInformation::where('user_id', $id)->first();

            if ($ehi) {
                if ($ehi->mental_details) {
                    $ehi->mental_details = unserialize($ehi->mental_details);
                }
                if ($ehi->physical_details) {
                    $ehi->physical_details = unserialize($ehi->physical_details);
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Health information retrieved successfully.',
                    'data' => $ehi
                ], 200);
            } else {
                return response()->json([
                    'error' => true,
                    'message' => 'Health information not found.'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Failed to retrieve health information. ' . $e->getMessage()
            ], 500);
        }
    }


}
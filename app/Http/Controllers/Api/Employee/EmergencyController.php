<?php

namespace App\Http\Controllers\Api\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee\EmergencyDetails;
use Illuminate\Support\Facades\Validator;

class EmergencyController extends Controller
{
    public function store(Request $request)
    {
        // $validator = $request->all();
        $data = Validator::make($request->all(), EmergencyDetails::$rules);

        if ($data->fails()) {
            return response()->json(['error' => $data->errors()], 400);
        }

        try {
            $eed = EmergencyDetails::where('user_id', $request->user_id)->first();
            if (!$eed) {
                $eed = new EmergencyDetails;
                $eed->user_id = $request->user_id;
            }
            $eed->emergency_primary_name = $request->emergency_primary_name .' '. $request->emergency_primary_lname;
            $eed->relationship_primary = $request->relationship_primary;
            $eed->emergency_primary_contact = $request->emergency_primary_contact;
            $eed->emergency_secondary_name = $request->emergency_secondary_name .' '. $request->emergency_secondary_lname;
            $eed->relationship_secondary = $request->relationship_secondary;
            $eed->emergency_secondary_contact = $request->emergency_secondary_contact;
            $eed->comment = $request->comment;
            $eed->save();

            return response()->json([
                'success' => true,
                'message' => 'Employee emergency information stored successfully.',
                'data' => $eed
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Failed to store employee emergency information. ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $emergencyDetails = EmergencyDetails::where('user_id', $id)->first();

            if (!$emergencyDetails) {
                return response()->json([
                    'error' => true,
                    'message' => 'Emergency details not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Emergency details retrieved successfully.',
                'data' => $emergencyDetails
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Failed to retrieve emergency details. ' . $e->getMessage()
            ], 500);
        }
    }


}
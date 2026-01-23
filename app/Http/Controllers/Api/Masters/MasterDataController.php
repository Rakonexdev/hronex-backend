<?php

namespace App\Http\Controllers\Api\Masters;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class MasterDataController extends Controller
{
    public function designations()
    {
        try {
            $masters_data = DB::table('designations')
                ->select('designations.id', 'designations.name', 'designations.description', 'designations.status', 'departments.name as department_name')
                ->leftJoin('departments', 'designations.department_id', '=', 'departments.id')
                ->get();
            $departments = DB::table('departments')->where('active', '1')->get();

            return response()->json([
                'data' => [
                    'masters_data' => $masters_data,
                    'departments' => $departments,
                ],
                'message' => 'Data fetched successfully.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'An error occurred while fetching data from the database.',
            ], 500);
        }
    }

    public function getDesignations($id)
    {
        try {
            $masters_data = DB::table('designations')
                ->select('designations.id', 'designations.name', 'designations.description', 'designations.status', 'departments.name as department_name')
                ->leftJoin('departments', 'designations.department_id', '=', 'departments.id')
                ->get();
            $departments = DB::table('departments')->where('active', '1')->get();

            return response()->json([
                'data' => [
                    'masters_data' => $masters_data,
                    'departments' => $departments,
                ],
                'message' => 'Data fetched successfully.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'An error occurred while fetching data from the database.',
            ], 500);
        }
    }

    public function allMasters($table) {
        $table_names_list = ['appraisal_data', 'approval_status','budget_type',
            'contract_type', 'countries', 'departments', 'designations', 'employee_departments',
            'employee_designations', 'inactive_reason',
            'inactive_status', 'leave_applications',
            'leave_application_status', 'leave_types'];

        if (!in_array($table, $table_names_list)) {
            return response()->json(['error' => 'Invalid table name', 'available_tables' => $table_names_list], 404);
        }

        try {
            $masters_data = DB::table($table)->get();
            return response()->json($masters_data);
        } catch (Exception $e) {
            return response()->json(['error' => 'Table not found', 'available_tables' => $table_names_list], 404);
        }
    }
}
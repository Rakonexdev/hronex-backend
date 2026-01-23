<?php

namespace App\Http\Controllers\Masters;
use Illuminate\Support\Facades\DB;
//use DB;
use Session;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HrmController;
use Doctrine\DBAL\Driver\AbstractMySQLDriver;
use OwenIt\Auditing\Facades\Audi;
use OwenIt\Auditing\Models\Audit;
use App\Models\Employee\Employees;
use App\Models\Masters\Appraisal_datas;

class MastersController extends Controller
{
    public $table;
    public $view_name;
    public function __construct()
    {
        new HrmController;
        $first_segment = request()->segment(1);
        $table_names = DB::getDoctrineSchemaManager()->listTableNames();
        foreach ($table_names as $name) {
            $path_name = str_replace("_", "", $name);
            if($first_segment === $path_name){
                $this->view_name = $first_segment;
                return $this->table = $name;
            }
        }
        $this->table = $first_segment;
    }

    public function index()
    {
        $masters_data = DB::table($this->table)->get();
        $edit_masters = null;
        $dropdowns = [
           'data' => $masters_data
        ];
        /*'Appraisal type' data for appraisal data master  */
        if('appraisal_data' == $this->table){
            $appr_types = DB::table('appraisal_type')->where('active', 1)->get();
            if($masters_data->isNotEmpty()){
                foreach($masters_data as $mdata){
                    if(0==$mdata->type){
                        $mdata->type_name = 'Others';
                    }else{
                        $appr_type_data = DB::table('appraisal_type')
                                    ->where('active', 1)
                                    ->where('id', $mdata->type)
                                    ->first();
                        $mdata->type_name = $appr_type_data->type_name;
                    }
                }
            }
        }else{
            $appr_types = [];
        }

        if('notice_period' == $this->table){
            $employees = DB::table('employees')->select('id', 'name', 'lname', 'employee_no')
                                               ->where('status', 1)
                                               ->orderByRaw("CASE 
                                                            WHEN employees.employee_no REGEXP '^[0-9]+$' THEN LPAD(employees.employee_no, 10, '0') 
                                                            ELSE employees.employee_no END")
                                                ->orderBy('employees.employee_no')
                                               ->get();
            if($masters_data->isNotEmpty()){
                foreach($masters_data as $mdata){
                    $emp = DB::table('employees')->select('id', 'name', 'lname', 'employee_no')
                                                ->where('status', 1)
                                                ->where('id', $mdata->employee_id)
                                                ->first();                    
                    $mdata->employee_no = $emp->employee_no;
                    $mdata->employee_name = $emp->name.' '.$emp->lname;
                }
            }
        }else{
            $employees = null;
        }

        return view('masters.'.$this->table , compact('masters_data', 'edit_masters', 'dropdowns', 'appr_types', 'employees'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $table = $this->table;
        if ($request->has('academic_title')) {
            $request->validate([
                    'academic_title' => 'required|max:100|unique:academic_year,title',
                    'academic_year_from' => 'required',
                    'academic_year_to' => 'required',
                ],
                [
                    'academic_title.unique' => 'The Academic Name is already in use.',
                    'academic_title.required' => 'The Academic Name is required.',
                    'academic_title.max' => 'Academic Name should not exceed 100 characters.',
                    'academic_year_from.required' => 'Beginning of academic year is required.',
                    'academic_year_to.required' => 'Academic final year is required.'

                ]);

            $data = [
                'title' => $request->academic_title,
                'start_from' => $request->academic_year_from,
                'start_to' => $request->academic_year_to,
                'active' => $request->status
            ];
        }

        if ($request->has('department_name')) {
            $request->validate([
                'department_name' => 'required|max:100|unique:departments,name',
                'description' => 'required'
            ],
            [
                'department_name.unique' => 'The department Name is already in use.',
                'department_name.required' => 'The department Name is required.',
                'department_name.max' => 'Department Name should not exceed 100 characters.',
                'description.required' => 'Description is required.'

            ]);

            $data = [
                'name' => $request->department_name,
                'description' => $request->description,
                'active' => $request->status
            ];
        }

        if ($request->has('approval_status_name')) {
            $request->validate([
                'approval_status_name' => 'required|max:100',
                'description' => 'required'
            ],
            [
                'approval_status_name.required' => 'The Approval status name is required.',
                'approval_status_name.max' => 'Approval status name Name should not exceed 100 characters.',
                'description.required' => 'Description is required.'

            ]);

            $data = [
                'name' => $request->approval_status_name,
                'description' => $request->description,
                'active' => $request->status
            ];
        }

        if ($request->has('paidstatus_name')) {
            $request->validate([
                'paidstatus_name' => 'required|max:100',
                'description' => 'required'
            ],
            [
                'paidstatus_name.required' => 'The Paid status name is required.',
                'paidstatus_name.max' => 'Paid status name Name should not exceed 100 characters.',
                'description.required' => 'Description is required.'
            ]);

            $data = [
                'name' => $request->paidstatus_name,
                'description' => $request->description,
                'active' => $request->status
            ];
        }

        if ($request->has('payment_deduction_name')) {
            $request->validate([
                'payment_deduction_name' => 'required|max:100',
                'description' => 'required'
            ],
            [
                'payment_deduction_name.required' => 'The Paiment deduction name is required.',
                'payment_deduction_name.max' => 'Paiment deduction status name should not exceed 100 characters.',
                'description.required' => 'Description is required.'

            ]);

            $data = [
                'name' => $request->payment_deduction_name,
                'description' => $request->description,
                'active' => $request->status
            ];
        }

        if ($request->has('schoolshift_name')) {
            $request->validate([
                'schoolshift_name' => 'required|max:100',
                'description' => 'required'
            ],
            [
                'schoolshift_name.required' => 'The Paiment deduction name is required.',
                'schoolshift_name.max' => 'Paiment deduction status name should not exceed 100 characters.',
                'description.required' => 'Description is required.'

            ]);

            $data = [
                'name' => $request->schoolshift_name,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'description' => $request->description,
                'active' => $request->status
            ];
        }

        if ($request->has('contracttype_name')) {
            $request->validate([
                'contracttype_name' => 'required|max:100',
                'description' => 'required'
            ],
            [
                'contracttype_name.required' => 'The Contract type name is required.',
                'contracttype_name.max' => 'Paiment Contract type name should not exceed 100 characters.',
                'description.required' => 'Description is required.'

            ]);

            $data = [
                'name' => $request->contracttype_name,
                'description' => $request->description,
                'active' => $request->status
            ];
        }

        if ($request->has('relevantdegree_name')) {
            $request->validate([
                'relevantdegree_name' => 'required|max:100',
                'description' => 'required'
            ],
            [
                'relevantdegree_name.required' => 'The Relevant degree name is required.',
                'relevantdegree_name.max' => 'Paiment Relevant degree name should not exceed 100 characters.',
                'description.required' => 'Description is required.'

            ]);

            $data = [
                'name' => $request->relevantdegree_name,
                'description' => $request->description,
                'active' => $request->status
            ];
        }

        if ($request->has('inactivestatus_name')) {
            $request->validate([
                'inactivestatus_name' => 'required|max:100'
            ],
            [
                'inactivestatus_name.required' => 'The Inactive reason is required.',
                'inactivestatus_name.max' => 'Paiment Inactive reason should not exceed 100 characters.'

            ]);

            $data = [
                'name' => $request->inactivestatus_name,
                'active' => $request->status
            ];
        }

        if ($request->has('inactivereason_name')) {
            $request->validate([
                'inactivereason_name' => 'required|max:100'
            ],
            [
                'inactivereason_name.required' => 'The Inactive reason is required.',
                'inactivereason_name.max' => 'Paiment Inactive reason should not exceed 100 characters.'

            ]);

            $data = [
                'name' => $request->inactivereason_name,
                'active' => $request->status
            ];
        }

        if ($request->has('relationship_name')) {
            $request->validate([
                'relationship_name' => 'required|max:100'
            ],
            [
                'relationship_name.required' => 'The Relationship is required.',
                'relationship_name.max' => 'Paiment Relationship should not exceed 100 characters.'

            ]);

            $data = [
                'name' => $request->relationship_name,
                'active' => $request->status
            ];
        }

        if ($request->has('leave_type_name')) {
            $request->validate([
                'leave_type_name' => 'required|max:100',
                'leave_type_code' => 'required|max:6',
                'bg_color' => 'required',
                /*'academic_year' => 'required',*/
                'applicable_to' => 'required',
                'leave_days' => 'required|integer',
                'description' => 'required'
            ],
            [
                'leave_type_name.required' => 'The Leave type name is required.',
                'leave_type_name.max' => 'Leave type name should not exceed 100 characters.',
                'leave_type_code.required' => 'The Leave type code is required.',
                'leave_type_code.max' => 'Leave type code should not exceed 6 characters.',
                'bg_color.required' => 'Please choose color.',
                /*'academic_year.required' => 'Academic year is required.',*/
                'applicable_to.required' => 'Applicable is required.',
                'leave_days.required' => 'Leave days is required.',
                'leave_days.integer' => 'Days of leave must be a number..',
                'description.required' => 'Description is required.',

            ]);

            $user_id = Auth::user()->id;

            $data = [
                'name' => $request->leave_type_name,
                'code' => $request->leave_type_code,
                'bg_color' => $request->bg_color,
                'academic_year' => 1, /*$request->academic_year,*/
                'applicable_to' => $request->applicable_to,
                'leave_days' => $request->leave_days,
                'description' => $request->description,
                'active' => $request->status,
                'created_by' => $user_id
            ];
        }

        if ($request->has('appraisal_type_name')) {
            $request->validate([
                'appraisal_type_name' => 'required|max:200',                
            ],
            [
                'appraisal_type_name.required' => 'The Appraisal type name is required.',

            ]);

            $data = [
                'type_name' => $request->appraisal_type_name,                
                'active' => $request->status,
            ];
        }

        if ($request->has('appraisal_applicable')) {
                    $request->validate([
                        'appraisal_applicable' => 'required|max:200',                
                    ],
                    [
                        'appraisal_applicable.required' => 'The Appraisal type name is required.',
        
                    ]);
        
                    $data = [
                        'applicable' => $request->appraisal_applicable,                
                        'status' => $request->status,
                    ];
                }

        if ($request->has('appraisal_data_name')) {
            $request->validate([
                'appraisal_data_name' => 'required|max:100',
                'details' => 'required',
                'applicable_to' => 'required',
                //'description' => 'required'
            ],
            [
                'appraisal_data_name.required' => 'The Appraisal data name is required.',
                'appraisal_data_name.max' => 'Paiment Appraisal data name should not exceed 100 characters.',
                'details.required' => 'Details is required.',
                'applicable_to.required' => 'Applicable is required.',
                //'description.required' => 'Description is required.',

            ]);

            $data = [
                'type' => $request->appraisal_data_name,
                'details' => $request->details,
                'applicable_to' => $request->applicable_to,
                'description' => $request->description,
                'active' => $request->status,
            ];
        }

        if ($request->has('budget_type')) {
            $request->validate([
                'budget_type' => 'required|max:100',
                'year_to' => 'required',
                'year_from' => 'required',
                'amount' => 'required'
            ],
            [
                'budget_type.required' => 'The Budget type is required.',
                'budget_type.max' => 'Budget type should not exceed 100 characters.',
                'year_to.required' => 'Beginning of year is required.',
                'year_from.required' => 'Ending year is required.',
                'amount.required' => 'Amount is required.',

            ]);

            $data = [
                'budget_type' => $request->budget_type,
                'start_to' => $request->year_to,
                'start_from' => $request->year_from,
                'amount' => $request->amount
            ];
        }

        if ($request->has('medical_ailment_name')) {
            $request->validate([
                'medical_ailment_name' => 'required|max:100',
                'description' => 'required',
                'type' => 'required',
                'status' => 'required'
            ],
            [
                'medical_ailment_name.required' => 'Medical ailment name is required.',
                'medical_ailment_name.max' => 'medical ailment name should not exceed 100 characters.',
                'description.required' => 'Description is required.',
                'type.required' => 'Type is required.',
                'status.required' => 'status is required.',

            ]);

            $data = [
                'name' => $request->medical_ailment_name,
                'type' => $request->type,
                'description' => $request->description,
                'active' => $request->status
            ];
        }

        if ($request->has('np_days')) {
            $request->validate([
                'employee_id' => 'required|unique:notice_period',
                'np_days' => 'required|integer'
            ],
            [
                'employee_id.required' => 'Please choose an employee',
                'employee_id.unique' => 'Notice period has been already added for this employee',
                'np_days.required' => 'Please fill the notice period days',
                'np_days.integer' => 'Notice period days must be a number',

            ]);

            $data = [
                'employee_id' => $request->employee_id,
                'np_days' => $request->np_days,
                'np_description' => $request->np_description
            ];
        }

        if(!empty($table)){
            DB::beginTransaction();

                try {
                    $results = DB::table($table)->insert($data);
                    // Create an instance of the Audit model and save it
                    /*$audit = new Audit;
                    $audit->user_id = auth()->id(); // Or manually set the user_id
                    $audit->event = 'create'; // The event type (create, update, delete)
                    $audit->auditable_type = $table; // The audited model name
                    $audit->auditable_id = $results; // The record ID
                    $audit->old_values = null; // Any old values before the changes
                    $audit->new_values = $data; // The new values after the changes
                    $audit->url = url()->previous(); // The URL of the request
                    $audit->ip_address = $request->ip(); // The IP address of the request
                    $audit->save(); */

                    DB::commit();

                    return back()->with('success', trans('messages.successC'));
                } catch (\Exception $e) {
                    DB::rollback();

                    return back()->with('error', 'Error Processing');
                }
        }else{
            return back()->with('error', 'Error Processing');
        }
    }

    public function show($id)
    {
        $masters_data = DB::table($this->table)->get();
        $edit_masters = DB::table($this->table)->find($id);
        /*'Appraisal type' data for appraisal data master  */
        if('appraisal_data' == $this->table){
            $appr_types = DB::table('appraisal_type')->where('active', 1)->get();
            if($masters_data->isNotEmpty()){
                foreach($masters_data as $mdata){
                    if(0==$mdata->type){
                        $mdata->type_name = 'Others';
                    }else{
                        $appr_type_data = DB::table('appraisal_type')
                                    ->where('active', 1)
                                    ->where('id', $mdata->type)
                                    ->first();
                        $mdata->type_name = $appr_type_data->type_name;
                    }
                }
            }
        }else{
            $appr_types = [];
        }

        if('notice_period' == $this->table){
            $employees = DB::table('employees')->select('id', 'name', 'lname', 'employee_no')
                                               ->where('status', 1)
                                               ->orderByRaw("CASE 
                                                            WHEN employees.employee_no REGEXP '^[0-9]+$' THEN LPAD(employees.employee_no, 10, '0') 
                                                            ELSE employees.employee_no END")
                                                ->orderBy('employees.employee_no')
                                               ->get();
            if($masters_data->isNotEmpty()){
                foreach($masters_data as $mdata){
                    $emp = DB::table('employees')->select('id', 'name', 'lname', 'employee_no')
                                                ->where('status', 1)
                                                ->where('id', $mdata->employee_id)
                                                ->first();                    
                    $mdata->employee_no = $emp->employee_no;
                    $mdata->employee_name = $emp->name.' '.$emp->lname;
                }
            }
        }else{
            $employees = null;
        }

        return view('masters.'.$this->table , compact('masters_data', 'edit_masters', 'appr_types', 'employees'));
    }

    public function status($id, $status)
    {
        $state = $status ? 0 : 1 ;
        DB::table($this->table)
            ->where('id', $id)
            ->update(['active' => $state]);
        return back()->with('success', trans('messages.successU'));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        
        $data = [];
        if ($request->has('academic_title')) {
            $request->validate([
                    'academic_title' => 'required|max:100',
                    'academic_year_from' => 'required',
                    'academic_year_to' => 'required',
                ],
                [
                    // 'academic_title.unique' => 'The Academic title is already in use.',
                    'academic_title.required' => 'The Academic Name is required.',
                    'academic_title.max' => 'Academic Name should not exceed 100 characters.',
                    'academic_year_from.required' => 'Beginning of academic year is required.',
                    'academic_year_to.required' => 'Academic final year is required.'

                ]);

            $data = [
                'title' => $request->academic_title,
                'start_from' => $request->academic_year_from,
                'start_to' => $request->academic_year_to,
                'active' => $request->status
            ];
        }

        if ($request->has('department_name')) {
            $request->validate([
                'department_name' => 'required|max:100',
                'description' => 'required'
            ],
            [
                'department_name.required' => 'The department Name is required.',
                'department_name.max' => 'Department Name should not exceed 100 characters.',
                'description.required' => 'Description is required.'

            ]);

            $data = [
                'name' => $request->department_name,
                'description' => $request->description,
                'active' => $request->status
            ];
        }

        if ($request->has('approval_status_name')) {
            $request->validate([
                'approval_status_name' => 'required|max:100',
                'description' => 'required'
            ],
            [
                'approval_status_name.required' => 'The Approval status name is required.',
                'approval_status_name.max' => 'Approval status name Name should not exceed 100 characters.',
                'description.required' => 'Description is required.'

            ]);

            $data = [
                'name' => $request->approval_status_name,
                'description' => $request->description,
                'active' => $request->status
            ];
        }

        if ($request->has('paidstatus_name')) {
            $request->validate([
                'paidstatus_name' => 'required|max:100',
                'description' => 'required'
            ],
            [
                'paidstatus_name.required' => 'The Paid status name is required.',
                'paidstatus_name.max' => 'Paid status name Name should not exceed 100 characters.',
                'description.required' => 'Description is required.'

            ]);

            $data = [
                'name' => $request->paidstatus_name,
                'description' => $request->description,
                'active' => $request->status
            ];
        }

        if ($request->has('payment_deduction_name')) {
            $request->validate([
                'payment_deduction_name' => 'required|max:100',
                'description' => 'required'
            ],
            [
                'payment_deduction_name.required' => 'The Paiment deduction name is required.',
                'payment_deduction_name.max' => 'Paiment deduction status name should not exceed 100 characters.',
                'description.required' => 'Description is required.'

            ]);

            $data = [
                'name' => $request->payment_deduction_name,
                'description' => $request->description,
                'active' => $request->status
            ];
        }

        if ($request->has('schoolshift_name')) {
            $request->validate([
                'schoolshift_name' => 'required|max:100',
                'description' => 'required'
            ],
            [
                'schoolshift_name.required' => 'The Paiment deduction name is required.',
                'schoolshift_name.max' => 'Paiment deduction status name should not exceed 100 characters.',
                'description.required' => 'Description is required.'

            ]);

            $data = [
                'name' => $request->schoolshift_name,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'description' => $request->description,
                'active' => $request->status
            ];
        }

        if ($request->has('contracttype_name')) {
            $request->validate([
                'contracttype_name' => 'required|max:100',
                'description' => 'required'
            ],
            [
                'contracttype_name.required' => 'The Contract type name is required.',
                'contracttype_name.max' => 'Paiment Contract type name should not exceed 100 characters.',
                'description.required' => 'Description is required.'

            ]);

            $data = [
                'name' => $request->contracttype_name,
                'description' => $request->description,
                'active' => $request->status
            ];
        }

        if ($request->has('relevantdegree_name')) {
            $request->validate([
                'relevantdegree_name' => 'required|max:100',
                'description' => 'required'
            ],
            [
                'relevantdegree_name.required' => 'The Relevant degree name is required.',
                'relevantdegree_name.max' => 'Paiment Relevant degree name should not exceed 100 characters.',
                'description.required' => 'Description is required.'

            ]);

            $data = [
                'name' => $request->relevantdegree_name,
                'description' => $request->description,
                'active' => $request->status
            ];
        }

        if ($request->has('inactivestatus_name')) {
            $request->validate([
                'inactivestatus_name' => 'required|max:100'
            ],
            [
                'inactivestatus_name.required' => 'The Inactive reason is required.',
                'inactivestatus_name.max' => 'Paiment Inactive reason should not exceed 100 characters.'

            ]);

            $data = [
                'name' => $request->inactivestatus_name,
                'active' => $request->status
            ];
        }

        if ($request->has('inactivereason_name')) {
            $request->validate([
                'inactivereason_name' => 'required|max:100'
            ],
            [
                'inactivereason_name.required' => 'The Inactive reason is required.',
                'inactivereason_name.max' => 'Paiment Inactive reason should not exceed 100 characters.'

            ]);

            $data = [
                'name' => $request->inactivereason_name,
                'active' => $request->status
            ];
        }

        if ($request->has('relationship_name')) {
            $request->validate([
                'relationship_name' => 'required|max:100'
            ],
            [
                'relationship_name.required' => 'The Relationship is required.',
                'relationship_name.max' => 'Paiment Relationship should not exceed 100 characters.'

            ]);

            $data = [
                'name' => $request->relationship_name,
                'active' => $request->status
            ];
        }

        if ($request->has('leave_type_name')) {
            $request->validate([
                'leave_type_name' => 'required|max:100',
                'leave_type_code' => 'required|max:6',
                'bg_color' => 'required',
                /*'academic_year' => 'required',*/
                'applicable_to' => 'required',
                'leave_days' => 'required|integer',
                'description' => 'required'
            ],
            [
                'leave_type_name.required' => 'The Leave type name is required.',
                'leave_type_name.max' => 'Leave type name should not exceed 100 characters.',
                'leave_type_code.required' => 'The Leave type code is required.',
                'leave_type_code.max' => 'Leave type code should not exceed 6 characters.',
                'bg_color.required' => 'Please choose color.',
                /*'academic_year.required' => 'Academic year is required.',*/
                'applicable_to.required' => 'Applicable is required.',
                'leave_days.required' => 'Leave days is required.',
                'leave_days.integer' => 'Days of leave must be a number..',
                'description.required' => 'Description is required.',

            ]);

            $user_id = Auth::user()->id;

            $data = [
                'name' => $request->leave_type_name,
                'code' => $request->leave_type_code,
                'bg_color' => $request->bg_color,
                'academic_year' => 1, /*$request->academic_year,*/
                'applicable_to' => $request->applicable_to,
                'leave_days' => $request->leave_days,
                'description' => $request->description,
                'active' => $request->status,
                'created_by' => $user_id
            ];
        }

        if ($request->has('appraisal_type_name')) {
            $request->validate([
                'appraisal_type_name' => 'required|max:200',                
            ],
            [
                'appraisal_type_name.required' => 'The Appraisal type name is required.',

            ]);

            $data = [
                'type_name' => $request->appraisal_type_name,                
                'active' => $request->status,
            ];
        }
        if ($request->has('appraisal_applicable')) {
                    $request->validate([
                        'appraisal_applicable' => 'required|max:200',                
                    ],
                    [
                        'appraisal_applicable.required' => 'The Appraisal type name is required.',
        
                    ]);
        
                    $data = [
                        'applicable' => $request->appraisal_applicable,                
                        'status' => $request->status,
                    ];
                }


        if ($request->has('appraisal_data_name')) {
            $request->validate([
                'appraisal_data_name' => 'required|max:100',
                'details' => 'required',
                'applicable_to' => 'required',
                //'description' => 'required'
            ],
            [
                'appraisal_data_name.required' => 'The Appraisal data name is required.',
                'appraisal_data_name.max' => 'Paiment Appraisal data name should not exceed 100 characters.',
                'details.required' => 'Details is required.',
                'applicable_to.required' => 'Applicable is required.',
                //'description.required' => 'Description is required.',

            ]);

            $data = [
                'type' => $request->appraisal_data_name,
                'details' => $request->details,
                'applicable_to' => $request->applicable_to,
                'description' => $request->description,
                'active' => $request->status,
            ];
        }

        if ($request->has('budget_type')) {
            $request->validate([
                'budget_type' => 'required|max:100',
                'year_to' => 'required',
                'year_from' => 'required',
                'amount' => 'required'
            ],
            [
                'budget_type.required' => 'The Budget type is required.',
                'budget_type.max' => 'Budget type should not exceed 100 characters.',
                'year_to.required' => 'Beginning of year is required.',
                'year_from.required' => 'Ending year is required.',
                'amount.required' => 'Amount is required.',

            ]);

            $data = [
                'budget_type' => $request->budget_type,
                'start_to' => $request->year_to,
                'start_from' => $request->year_from,
                'amount' => $request->amount
            ];
        }

        if ($request->has('medical_ailment_name')) {
            $request->validate([
                'medical_ailment_name' => 'required|max:100',
                'description' => 'required',
                'type' => 'required',
                'status' => 'required'
            ],
            [
                'medical_ailment_name.required' => 'Medical ailment name is required.',
                'medical_ailment_name.max' => 'medical ailment name should not exceed 100 characters.',
                'description.required' => 'Description is required.',
                'type.required' => 'Type is required.',
                'status.required' => 'status is required.',

            ]);

            $data = [
                'name' => $request->medical_ailment_name,
                'type' => $request->type,
                'description' => $request->description,
                'active' => $request->status
            ];
        }

        if ($request->has('np_days')) {
            $request->validate([
                'employee_id' => 'required',
                'np_days' => 'required|integer'
            ],
            [
                'employee_id.required' => 'Please choose an employee',
                'np_days.required' => 'Please fill the notice period days',
                'np_days.integer' => 'Notice period days must be a number',

            ]);

            $data = [
                'employee_id' => $request->employee_id,
                'np_days' => $request->np_days,
                'np_description' => $request->np_description
            ];
        }


        
        DB::beginTransaction();

        try {
            $results = DB::table($this->table)->where('id', $id)->update($data);
            // Create an instance of the Audit model and save it
            /*$audit = new Audit;
            $audit->user_id = auth()->id(); // Or manually set the user_id
            $audit->event = 'update'; // The event type (create, update, delete)
            $audit->auditable_type = $table; // The audited model name
            $audit->auditable_id = $id; // The record ID
            $audit->old_values = null; // Any old values before the changes
            $audit->new_values = $data; // The new values after the changes
            $audit->url = url()->previous(); // The URL of the request
            $audit->ip_address = $request->ip(); // The IP address of the request             
            $audit->save();*/

            DB::commit();

            return back()->with('success', trans('messages.successU'));
        } catch (\Exception $e) {
            DB::rollback();

            return back()->with('error', 'Error Processing');
        }
        return back()->with('success', trans('messages.successU'));
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $data = DB::table($this->table)->where('id', $id)->delete();
            // Create an instance of the Audit model and save it
            $audit = new Audit;
            $audit->user_id = auth()->id(); // Or manually set the user_id
            $audit->event = 'delete'; // The event type (create, update, delete)
            $audit->auditable_type = $this->table; // The audited model name
            $audit->auditable_id = $id; // The record ID
            $audit->old_values = null; // Any old values before the changes
            $audit->new_values = $data; // The new values after the changes
            $audit->url = url()->previous(); // The URL of the request
            $audit->ip_address = $request->ip(); // The IP address of the request
            $audit->save();

            DB::commit();

            return back()->with('success', trans('messages.successC'));
        } catch (\Exception $e) {
            DB::rollback();

            return back()->with('error', 'Error Processing');
        }
        return back()->with('success', trans('messages.successD'));
    }
     public function assign_applicable_filter(Request $request)
    {
        $dept = $request->input('dept');
        $valueName = $request->input('value');
        $valueId = DB::table('appraisal_type')->where('id', $valueName)->pluck('type_name')->first();
        return view('appraisal.appraisal_data_view',compact('dept','valueName','valueId'));
    }
        public function assign_applicable_charcter_filter(Request $request)
    {
        $id = $request->input('empId');
    
        $employee = Employees::with('designations','departments')->find($id);
        $appraisal_datas = Appraisal_datas::get();
        $dept = $request->input('dept');
        $valueName = $request->input('value');
        $valueId = DB::table('appraisal_type')->where('id', $valueName)->pluck('type_name')->first();
        return view('appraisal.appraisal_character_data_view',compact('employee','appraisal_datas','dept','valueName','valueId'));
    }
}
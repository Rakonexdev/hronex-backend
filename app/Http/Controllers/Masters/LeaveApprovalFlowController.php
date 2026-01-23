<?php

namespace App\Http\Controllers\Masters;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Masters\Designation;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HrmController;
use Illuminate\Support\Facades\Validator;
use App\Models\Leave\LeaveApprovalFlow;
use App\Models\Leave\LeaveApprovalFlowStep;
use App\Models\Masters\Department;

class LeaveApprovalFlowController extends HrmController
{
    public function index()
    {
        $flows = LeaveApprovalFlow::with('steps')->get();
        return view('masters.approval-flows.index', compact('flows'));
    }

    public function create()
    {
        $roles = approval_roles();
        $departments = Department::where('active', true)->get();
        return view('masters.approval-flows.create', compact('roles', 'departments'));
    }

    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {

            $flow = LeaveApprovalFlow::create([
                'name' => $request->name,
                'department_id' => $request->department_id,
                'description' => $request->description
            ]);

            foreach ($request->steps as $order => $role) {
                LeaveApprovalFlowStep::create([
                    'leave_approval_flow_id' => $flow->id,
                    'role' => $role,
                    'step_order' => $order + 1
                ]);
            }
        });

        return redirect()->route('approval-flows.index')->with('success','Flow Created');
    }

    public function edit($id)
    {
        $flow = LeaveApprovalFlow::with('steps')->findOrFail($id);
        $roles = approval_roles();
        $departments = Department::where('active', true)->get();
        return view('masters.approval-flows.edit', compact('flow','roles','departments'));
    }

    public function update(Request $request, $id)
    {
        DB::transaction(function () use ($request, $id) {

            $flow = LeaveApprovalFlow::findOrFail($id);
            $flow->update($request->only('name','department_id','description'));

            $flow->steps()->delete();

            foreach ($request->steps as $order => $role) {
                LeaveApprovalFlowStep::create([
                    'leave_approval_flow_id' => $flow->id,
                    'role' => $role,
                    'step_order' => $order + 1
                ]);
            }
        });

        return redirect()->route('approval-flows.index')->with('success','Flow Updated');
    }
}

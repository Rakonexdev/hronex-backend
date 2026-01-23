<?php

namespace App\Http\Controllers\Masters;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\HrmController;
use App\Models\Masters\MOEapprovalStatus;
use Illuminate\Support\Facades\Validator;

class MOEapprovalStatusController extends HrmController
{
    public function index()
    {
        $masters_data   = MOEapprovalStatus::get();
        $edit_masters   = null;
        return view('masters.moe_approval_status', compact('masters_data', 'edit_masters'));
    }

    public function store(Request $request)
    {
        Validator::make($request->all(),
            [
                'moeapprstatus_name' => 'required|max:100'
            ],
            [
                'moeapprstatus_name.required' => 'The Name is required.',
                'moeapprstatus_name.max' => 'Name should not exceed 100 characters.',
            ]
        )->validate();
        $moe_approval_status = new MOEapprovalStatus;
        $moe_approval_status->name = $request->moeapprstatus_name;
        $moe_approval_status->active = $request->status;
        $moe_approval_status->save();

        if(!empty($moe_approval_status)){
            return redirect('moeapprstatus')->with('success', trans('messages.successC'));
        }else{
            return redirect('moeapprstatus')->with('error', 'Error Processing');
        }
    }

    public function show($id)
    {
        $masters_data   = MOEapprovalStatus::get();
        $edit_masters   = MOEapprovalStatus::find($id);
        return view('masters.moe_approval_status', compact('masters_data', 'edit_masters'));
    }

    public function status($id, $status)
    {
        $state = $status ? 0 : 1 ;
        DB::table('moe_approval_status')->where('id', $id)->update(['active' => $state]);
        return redirect('moeapprstatus')->with('success', trans('messages.successU'));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        Validator::make($request->all(),
            [
                'moeapprstatus_name' => 'required|max:100'
            ],
            [
                'moeapprstatus_name.required' => 'The Name is required.',
                'moeapprstatus_name.max' => 'Name should not exceed 100 characters.',
            ]
        )->validate();

        $moe_approval_status = MOEapprovalStatus::find($id);
        $moe_approval_status->name = $request->moeapprstatus_name;
        $moe_approval_status->active = $request->status;
        $moe_approval_status->save();

        if(!empty($moe_approval_status)){
            return redirect('moeapprstatus')->with('success', trans('messages.successC'));
        }else{
            return redirect('moeapprstatus')->with('error', 'Error Processing');
        }
    }

    public function destroy($id)
    {
        $moe_approval_status = MOEapprovalStatus::find($id);
        $moe_approval_status->delete();
        if(!empty($moe_approval_status)){
            return redirect('moeapprstatus')->with('success', trans('messages.successD'));
        }else{
            return redirect('moeapprstatus')->with('error', 'Error Processing');
        }
    }
}

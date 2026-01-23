<?php

namespace App\Http\Controllers\Masters;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Masters\Designation;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HrmController;
use Illuminate\Support\Facades\Validator;

class DesignationController extends HrmController
{
    public function index()
    {
        $masters_data   = DB::table('designations')
                                ->select('designations.id','designations.name', 'designations.description', 'designations.status', 'departments.name as department_name')
                                ->leftJoin('departments','designations.department_id','=','departments.id')
                                ->get();
        $departments    = DB::table('departments')->where('active', '1')->get();
        $edit_masters   = null;
        return view('masters.designations', compact('masters_data', 'edit_masters', 'departments'));
    }

    public function store(Request $request)
    {
        Validator::make($request->all(),
            [
                'designations_name' => 'required|max:100',
                'department_id' => 'required|integer',
                'description' => 'required'
            ],
            [
                'designations_name.required' => 'The Designation name is required.',
                'designations_name.max' => 'Designation name should not exceed 100 characters.',
                'department_id.required' => 'Select valid Department.',
                'description.required' => 'Description is required.'
            ]
        )->validate();

        $designation = new Designation;
        $designation->name = $request->designations_name;
        $designation->department_id = $request->department_id;
        $designation->description = $request->description;
        $designation->status = $request->status;
        $designation->save();

        if(!empty($designation)){
            return redirect('designations')->with('success', trans('messages.successC'));
        }else{
            return redirect('designations')->withError('Error Processing');
        }
    }

    public function show($id)
    {
        $masters_data   = DB::table('designations')
                            ->select('designations.id', 'designations.name', 'designations.description', 'designations.status', 'departments.name as department_name')
                            ->leftJoin('departments','designations.department_id','=','departments.id')
                            ->get();
        $edit_masters   = Designation::find($id);
        $departments    = DB::table('departments')->where('active', '1')->get();
        return view('masters.designations', compact('masters_data', 'edit_masters', 'departments'));
    }

    public function status($id, $status)
    {
        $state = $status ? 0 : 1 ;
        DB::table('designations')->where('id', $id)->update(['status' => $state]);
        return redirect('designations')->with('success', trans('messages.successU'));
    }

    public function update(Request $request, $id)
    {
        Validator::make($request->all(),
            [
                'designations_name' => 'required|max:100',
                'department_id' => 'required|integer',
                'description' => 'required'
            ],
            [
                'designations_name.required' => 'The Designation name is required.',
                'designations_name.max' => 'Designation name should not exceed 100 characters.',
                'department_id.required' => 'Select valid Department.',
                'description.required' => 'Description is required.'
            ]
        )->validate();

        $designation = Designation::find($id);
        $designation->name = $request->designations_name;
        $designation->department_id = $request->department_id;
        $designation->description = $request->description;
        $designation->status = $request->status;
        $designation->save();

        if(!empty($designation)){
            return redirect('designations')->with('success', trans('messages.successC'));
        }else{
            return redirect('designations')->with('error', 'Error Processing');
        }
    }

    public function destroy($id)
    {
        $designation = Designation::find($id);
        $designation->delete();
        if(!empty($designation)){
            return redirect('designations')->with('success', trans('messages.successD'));
        }else{
            return redirect('designations')->with('error', 'Error Processing');
        }
    }
}
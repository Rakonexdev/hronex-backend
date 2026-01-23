<?php

namespace App\Http\Controllers\Masters;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HrmController;
use Illuminate\Support\Facades\Validator;
use App\Models\Masters\PaymentDeductionType;

class PaymentDeductionTypeController extends HrmController
{
    public function index()
    {
        $masters_data   = PaymentDeductionType::get();
        $edit_masters   = null;
        return view('masters.payment_deduction_type', compact('masters_data', 'edit_masters'));
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        Validator::make($request->all(),
            [
                'name' => 'required|max:100',
                'description' => 'required'
            ],
            [
                'name.required' => 'The Name is required.',
                'name.max' => 'Name should not exceed 100 characters.',
                'description.required' => 'Description is required.'
            ]
        )->validate();

        $payment_deduction_type = new PaymentDeductionType;
        $payment_deduction_type->name = $request->name;
        $payment_deduction_type->description = $request->description;
        $payment_deduction_type->active = $request->status;
        $payment_deduction_type->save();

        if(!empty($payment_deduction_type)){
            return redirect('paydeductiontype')->with('success', trans('messages.successC'));
        }else{
            return redirect('paydeductiontype')->with('error', 'Error Processing');
        }
    }

    public function show($id)
    {
        $masters_data   = PaymentDeductionType::get();
        $edit_masters   = PaymentDeductionType::find($id);
        return view('masters.payment_deduction_type', compact('masters_data', 'edit_masters'));
    }

    public function status($id, $status)
    {
        $state = $status ? 0 : 1 ;
        DB::table('payment_deduction_type')->where('id', $id)->update(['active' => $state]);
        return redirect('paydeductiontype')->with('success', trans('messages.successU'));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        Validator::make($request->all(),
            [
                'name' => 'required|max:100',
                'description' => 'required'
            ],
            [
                'name.required' => 'The Name is required.',
                'name.max' => 'Name should not exceed 100 characters.',
                'description.required' => 'Description is required.'
            ]
        )->validate();

        $payment_deduction_type = PaymentDeductionType::find($id);
        $payment_deduction_type->name = $request->name;
        $payment_deduction_type->description = $request->description;
        $payment_deduction_type->active = $request->status;
        $payment_deduction_type->save();

        if(!empty($payment_deduction_type)){
            return redirect('paydeductiontype')->with('success', trans('messages.successC'));
        }else{
            return redirect('paydeductiontype')->with('error', 'Error Processing');
        }
    }

    public function destroy($id)
    {
        $payment_deduction_type = PaymentDeductionType::find($id);
        $payment_deduction_type->delete();
        if(!empty($payment_deduction_type)){
            return redirect('paydeductiontype')->with('success', trans('messages.successD'));
        }else{
            return redirect('paydeductiontype')->with('error', 'Error Processing');
        }
    }
}

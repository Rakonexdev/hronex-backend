<?php

namespace App\Http\Controllers\Employee;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Employee\Employees;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\HrmController;
use Illuminate\Support\Facades\Validator;

class EmployeesInfoController extends HrmController
{
    public function index()
    {
        $last_id = 1;

        $last_row = Employees::latest('id')->first();
        if(!empty($last_row))
            $last_id = $last_row->id;

        $data = NULL;

        return view('employee.employees_information', compact('last_id', 'data') );
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request['other_qualifications'] = array_filter($request->other_qualifications);
        $data = Validator::make($request->all(), Employees::$rules);
        if ($data->fails()) {
            return redirect()->back()->withErrors($data)->withInput();
        }
        $qid_attaches = $request->qid_attaches ? fileUpload([$request->qid_attaches]) : '';
        $passport_attaches = $request->passport_attaches ? fileUpload([$request->passport_attaches]) : '';
        $degree_attaches = $request->degree_attaches ? fileUpload([$request->degree_attaches]) : '';
        $disclaimer_ltr_moe_atch = $request->disclaimer_ltr_moe_atch ? fileUpload([$request->disclaimer_ltr_moe_atch]) : '';
        $declaration_ltr_moe_atch = $request->declaration_ltr_moe_atch ? fileUpload([$request->declaration_ltr_moe_atch]) : '';

        $data = $request->all();
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make(123456);
        $user->avatar = $request->avatar ? fileUpload([$request->avatar]) : '';
        $user->save();

        /*Role assigning to new users*/
        if(1 == $request->department){
            $user->assignRole('Employee');
        }else{
            if(16 == $request->designation){
                $user->assignRole('Principal');
            }else if(17 == $request->designation){
                $user->assignRole('Vp');
            }else if(20 == $request->designation){
                $user->assignRole('Accounts');
            }else if(22 == $request->designation || 26 == $request->designation){
                $user->assignRole('Hr');
            }
        }        

        $token = Str::random(64);
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
          ]);

        /*$token = $token."_mail_".$request->email;
        Mail::send('emails.user_create', ['token' => $token], function($message) use($request){
            $message->to($request->email);
            $message->subject('Account created');
          });*/
        if(!empty($request->other_qualifications)){
            $data['other_qualifications'] = serialize($request->other_qualifications);
        }else{
            unset($data['other_qualifications']);
        }

        $data['user_id'] = $user->id;
        $data['mobile1_code'] = getCountry('phone_code', $request->nationality);
        $data['mobile2_code'] = getCountry('phone_code', $request->nationality);
        $data['moe_approval_status'] = 1;

        $data['qid_attaches'] = $qid_attaches;
        $data['passport_attaches'] = $passport_attaches;
        $data['degree_attaches'] = $degree_attaches;
        $data['disclaimer_ltr_moe_atch'] = $disclaimer_ltr_moe_atch;
        $data['declaration_ltr_moe_atch'] = $declaration_ltr_moe_atch;

        $employees = new Employees;
        $employees->create($data);        
        
        return redirect()->route('payroll_information.show', $user->id)->with('success', trans('messages.successC'));
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            /*'lname' => 'required|string|max:255',*/
            'designation' => 'nullable|integer|max:255',
            'department' => 'nullable|integer|max:255',
            'school_shift' => 'required|integer|max:255',
        ],[
            'designation.integer' => 'Please select a valid designation.',
            'department.integer' => 'Please select a valid department.',
            'school_shift.required' => 'Please select a school shift.',
            'school_shift.integer' => 'Please select a valid school shift.'
        ]);
        try {
            $user = User::findOrFail($id);
            $user->name = $request->name .' '. $request->lname;
            if ($request->avatar) {
                $user->avatar = fileUpload([$request->avatar]);
            }
            $user->email = $request->email;
            $user->save();

            if ($request->qid_attaches){
                $qid_attch =  fileUpload([$request->qid_attaches]);} 
            else{ $qid_attch = NULL; }

            if ($request->passport_attaches){
                $passport_attch =  fileUpload([$request->passport_attaches]);} 
            else{ $passport_attch = NULL; }

            if ($request->degree_attaches){
                $degr_attch =  fileUpload([$request->degree_attaches]);} 
            else{ $degr_attch = NULL; }

            if ($request->disclaimer_ltr_moe_atch){
                $disclaimer_ltr_moe_atc =  fileUpload([$request->disclaimer_ltr_moe_atch]);}
            else{ $disclaimer_ltr_moe_atc = NULL; }

            if ($request->declaration_ltr_moe_atch){
                $decl_ltr_moe_atch = fileUpload([$request->declaration_ltr_moe_atch]);}
            else{ $decl_ltr_moe_atch = NULL; }

            if ($request->other_qualifications) {
                $other_qualifications = array_filter($request->other_qualifications);
                $other_qualifications = array_filter($other_qualifications, function($value) {
                    return $value !== "Add more Qualifications";
                });
                $request['other_qualifications'] = serialize($other_qualifications);
            }else{
                unset($request['other_qualifications']);
            }

            $request['mobile1_code'] = getCountry('phone_code', $request->nationality);
            $request['mobile2_code'] = getCountry('phone_code', $request->nationality);

            $employees = Employees::where('user_id', $id)->first();

            $employees->update($request->all());
            if(NULL!=$qid_attch)
                $employees->update(['qid_attaches' => $qid_attch]);
            if(NULL!=$passport_attch)
                $employees->update(['passport_attaches' => $passport_attch]);
            if(NULL!=$degr_attch)
                $employees->update(['degree_attaches' => $degr_attch]);
            if(NULL!=$disclaimer_ltr_moe_atc)
                $employees->update(['disclaimer_ltr_moe_atch' => $disclaimer_ltr_moe_atc]);
            if(NULL!=$decl_ltr_moe_atch)
                $employees->update(['declaration_ltr_moe_atch' => $decl_ltr_moe_atch]);

            return redirect()->back()->with('success', trans('messages.successU'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Some error occured!');
        }
    }

    public function destroy($id)
    {
        //
    }
}
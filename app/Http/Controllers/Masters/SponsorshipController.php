<?php

namespace App\Http\Controllers\Masters;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Masters\Sponsorship;
use App\Http\Controllers\HrmController;
use Illuminate\Support\Facades\Validator;

class SponsorshipController extends HrmController
{
    public function index()
    {
        $masters_data   = Sponsorship::get();
        $edit_masters   = null;
        return view('masters.sponsorship_status', compact('masters_data', 'edit_masters'));
    }

    public function store(Request $request)
    {
        Validator::make($request->all(),
            [
                'name' => 'required|max:100'
            ],
            [
                'name.required' => 'The Name is required.',
                'name.max' => 'Name should not exceed 100 characters.'
            ]
        )->validate();

        $sponsorship_status = new Sponsorship;
        $sponsorship_status->name = $request->name;
        $sponsorship_status->active = $request->status;
        $sponsorship_status->save();

        if(!empty($sponsorship_status)){
            return redirect('sponsstatus')->with('success', trans('messages.successC'));
        }else{
            return redirect('sponsstatus')->with('error', 'Error Processing');
        }
    }

    public function show($id)
    {
        $masters_data   = Sponsorship::get();
        $edit_masters   = Sponsorship::find($id);
        return view('masters.sponsorship_status', compact('masters_data', 'edit_masters'));
    }

    public function status($id, $status)
    {
        $state = $status ? 0 : 1 ;
        DB::table('sponsorship_status')->where('id', $id)->update(['active' => $state]);
        return redirect('sponsstatus')->with('success', trans('messages.successU'));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        Validator::make($request->all(),
            [
                'name' => 'required|max:100'
            ],
            [
                'name.required' => 'The Name is required.',
                'name.max' => 'Name should not exceed 100 characters.'
            ]
        )->validate();

        $sponsorship_status = Sponsorship::find($id);
        $sponsorship_status->name = $request->name;
        $sponsorship_status->active = $request->status;
        $sponsorship_status->save();

        if(!empty($sponsorship_status)){
            return redirect('sponsstatus')->with('success', trans('messages.successC'));
        }else{
            return redirect('sponsstatus')->with('error', 'Error Processing');
        }
    }

    public function destroy($id)
    {
        $sponsorship_status = Sponsorship::find($id);
        $sponsorship_status->delete();
        if(!empty($sponsorship_status)){
            return redirect('sponsstatus')->with('success', trans('messages.successD'));
        }else{
            return redirect('sponsstatus')->with('error', 'Error Processing');
        }
    }
}

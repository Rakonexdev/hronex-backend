<?php

namespace App\Http\Controllers;

use App\Models\ScfData;
use Illuminate\Http\Request;
use App\Http\Controllers\HrmController;
use Exception;

class ScfDataController extends HrmController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $edit_masters = null;
        $scf_datas = ScfData::get();
        return view('masters.scf_data',compact('scf_datas','edit_masters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $data = [
                'scf'=>$request->scf,
                'status'=>$request->status
            ];
            ScfData::create($data);
            return redirect()->back();

        }catch(Exception $e){
            return back()->with('error', $e->getMessage());
        }
      
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ScfData  $scfData
     * @return \Illuminate\Http\Response
     */
    public function show(ScfData $scfData,$id)
    {
        // dd($id);
        $edit_masters = ScfData::findorfail($id);
        $scf_datas = ScfData::get();
        return view('masters.scf_data',compact('edit_masters','scf_datas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ScfData  $scfData
     * @return \Illuminate\Http\Response
     */
    public function edit(ScfData $scfData)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ScfData  $scfData
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        try{
            // dd($id);
            $scf = ScfData::findorfail($id);
            $data = [
                'scf'=>$request->scf,
                'status'=>$request->status
            ];
            $scf->update($data);
            return back()->with('success', trans('messages.successU'));

        }catch(Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ScfData  $scfData
     * @return \Illuminate\Http\Response
     */
    public function destroy(ScfData $scfData)
    {
        //
    }
}

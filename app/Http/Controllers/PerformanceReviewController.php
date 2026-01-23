<?php

namespace App\Http\Controllers;

use App\Models\PerformanceReview;
use Illuminate\Http\Request;
use App\Http\Controllers\HrmController;

class PerformanceReviewController extends HrmController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $edit_masters = null;
        $reivews = PerformanceReview::get();
        return view('masters.performance_review',compact('edit_masters','reivews'));
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
                'performance_review'=>$request->performance_review,
                'status'=>$request->status
            ];
            PerformanceReview::create($data);
            return back()->with("succuess U");
        }catch (\Illuminate\Database\QueryException $e) {
            // SQL error occurred
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1062) {
                // MySQL Duplicate entry error code
                return redirect()->back()->with('error', 'Duplicate entry error. Please check your input data.');
            } else {
                return redirect()->back()->with('error', 'Database error: ' . $e->getMessage());
            }
        } catch (Exception $e) {
            // Other general errors
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PerformanceReview  $performanceReview
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $edit_masters = PerformanceReview::findorfail($id);
        $reivews = PerformanceReview::get();
        return view('masters.performance_review',compact('edit_masters','reivews'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PerformanceReview  $performanceReview
     * @return \Illuminate\Http\Response
     */
    public function edit(PerformanceReview $performanceReview)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PerformanceReview  $performanceReview
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        try{
            // dd($id);
            $reivews = PerformanceReview::findorfail($id);
            $data = [
                'performance_review'=>$request->performance_review,
                'status'=>$request->status
            ];
            $reivews->update($data);
            return back()->with('success', trans('messages.successU'));

        }catch(Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PerformanceReview  $performanceReview
     * @return \Illuminate\Http\Response
     */
    public function destroy(PerformanceReview $performanceReview)
    {
        //
    }
    
}

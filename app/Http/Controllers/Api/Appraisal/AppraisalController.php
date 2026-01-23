<?php

namespace App\Http\Controllers\Api\Appraisal;

use App\Http\Controllers\Controller;
use App\Models\Appraisal;
use App\Models\Masters\Appraisal_datas;
use Illuminate\Support\Facades\Validator;
use App\Models\AppraisalReport;
use Exception;
use Illuminate\Http\Request;
use App\Models\Pip;
use App\Models\PprForm;
use App\Models\PerformanceReview;
use App\Models\Scf;

class AppraisalController extends Controller
{
  
       public function getappraisalreview($id)
    {
        try {
            $appraisal_review = AppraisalReport::where('employee_id', $id)
                ->latest()
                ->first();
                
            if (!$appraisal_review) {
                return response()->json(['data' => null], 200);
            }
            $appraisal_data_ids = json_decode($appraisal_review->appraisal_data, true);
         
            $hod_rating = $appraisal_review->hod_rating;
            $stripped_hod_rating = stripslashes($hod_rating);            
            $stripped_hod_rating = json_decode($stripped_hod_rating);

            if ($stripped_hod_rating === null) {
                $hod_rating = null;
            } elseif (is_array($stripped_hod_rating) && count($stripped_hod_rating) > 0 && array_filter($stripped_hod_rating, function($element) {
                return $element !== null;
            }) === []) {
                $hod_rating = null;
            } else {
                $hod_rating = $stripped_hod_rating;

            }

            
            $principal_rating = $appraisal_review->principal_rating;   
            $stripped_principal_rating = stripslashes($principal_rating);
            $stripped_principal_rating = json_decode($stripped_principal_rating);
            //future datas
            $future_targets_dat = $appraisal_review->future_targets_data;
            $future_targets_datas = json_decode($future_targets_dat);
            $filtered_future_targets_data=[];
            if (is_array($future_targets_datas)) {
                foreach ($future_targets_datas as $future_target_data) {
                    if ($future_target_data !== null) {
                        $filtered_future_targets_data[] = $future_target_data;
                    }
                }
            }
            $future_targets_reviews = $appraisal_review->future_target_review_date;
            $future_targets_reviews = json_decode($future_targets_reviews);
            $filtered_future_targets_reviews=[];
            if (is_array($future_targets_reviews)) {
                foreach ($future_targets_reviews as $future_targets_review) {
                    if ($future_targets_review !== null) {
                        $filtered_future_targets_reviews[] = $future_targets_review;
                    }
                }
            }
            $future_targets_recommended = $appraisal_review->future_targets_recommended;
            $future_targets_recommended = json_decode($future_targets_recommended);
            $filtered_future_targets_recommended=[];
            if (is_array($future_targets_recommended)) {
                foreach ($future_targets_recommended as $future_targets_recommend) {
                    if ($future_targets_recommend !== null) {
                        $filtered_future_targets_recommended[] = $future_targets_recommend;
                    }
                }
            }
            $combined_future_targets = [];

            for ($i = 0; $i < count($filtered_future_targets_data); $i++) {
                $combined_future_targets[] = [
                    'data' => $filtered_future_targets_data[$i],
                    'date' => $filtered_future_targets_reviews[$i],
                    'recommended_by' => $filtered_future_targets_recommended[$i],
                ];
            }

            // training_title
            $training_titles = $appraisal_review->training_title;
            $training_titles = json_decode($training_titles);
            $filtered_training_titles = [];
            if (is_array($training_titles)) {
                foreach ($training_titles as $training_title) {
                    if ($training_title !== null) {
                        $filtered_training_titles[] = $training_title;
                    }
                }
            }
            $training_due_date = $appraisal_review->training_due_date;
            $training_due_date = json_decode($training_due_date);
            $filtered_due_date = [];
            if (is_array($training_due_date)) {
                foreach ($training_due_date as $training_due) {
                    if ($training_due !== null) {
                        $filtered_due_date[] = $training_due;
                    }
                }
            }
            $training_recommended = $appraisal_review->training_recommended;
            $training_recommended = json_decode($training_recommended);
            $filtered_training_recommended = [];
            if (is_array($training_recommended)) {
                foreach ($training_recommended as $training_recommend) {
                    if ($training_recommend !== null) {
                        $filtered_training_recommended[] = $training_recommend;
                    }
                }
            }
            if ($stripped_principal_rating === null) {
                $principal_rating = null;
            } elseif (is_array($stripped_principal_rating) && count($stripped_principal_rating) > 0 && array_filter($stripped_principal_rating, function($element) {
                    return $element !== null;
            }) === []) {
                    $principal_rating = null;
            } else {
                    $principal_rating = $stripped_principal_rating;
            }
            $combined_training = [];

            for ($i = 0; $i < count($filtered_training_titles); $i++) {
                $combined_training[] = [
                    'data' => $filtered_training_titles[$i],
                    'date' => $filtered_due_date[$i],
                    'recommended_by' => $filtered_training_recommended[$i],
                ];
            }
           
            // Retrieve the related appraisal data using the IDs
            $appraisal_data = Appraisal_datas::whereIn('id', $appraisal_data_ids)->get(['type', 'details']);
            
            $appraisal_review->appraisal_data = $appraisal_data;
            $combined_data_grouped = [];

            foreach ($hod_rating as $index => $hod) {
                $type = $appraisal_data[$index]['type'];

                if (!isset($combined_data_grouped[$type])) {
                    $combined_data_grouped[$type] = [];
                }

                $combined_data_grouped[$type][] = [
                    'type' => $type,
                    'details' => $appraisal_data[$index]['details'],
                    'hod_rating' => $hod,
                    'principal_rating' => $principal_rating[$index], 
                ];
            }
         
            $appraisal_review->combined_future_targets                = $combined_future_targets;
            $appraisal_review->combined_data                          = $combined_data_grouped;
            $appraisal_review->combined_training_title                = $combined_training;
            $appraisal_review->hod_rating                             = $hod_rating;
            $appraisal_review->principal_rating                       = $principal_rating;
            unset(
                $appraisal_review->future_targets_data,
                $appraisal_review->future_target_review_date,
                $appraisal_review->future_targets_recommended,
                $appraisal_review->training_title,
                $appraisal_review->training_due_date,
                $appraisal_review->training_recommended,
                $appraisal_review->appraisal_data,
                $appraisal_review->hod_rating,
                $appraisal_review->principal_rating,
            );
            return response()->json(['data' => $appraisal_review]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to retrieve appraisal detail'], 500);
        }
    }
    public function empolyeecomment(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer',
                // 'comment' => 'required',
                'employee_status'=>'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
        //$data = $request->comment;
            $appraisal_report = AppraisalReport::find($request->id);
            $appraisal_report->employee_comments = $request->comment;
            $appraisal_report->employee_status = $request->employee_status;
            $appraisal_report->save();
            return response()->json(['data'=>$appraisal_report]);

        }catch (Exception $e){
            return response()->json(['error' => 'Failed to retrieve appraisal detail'], 500);
        }   
    }
    public function get_pip_review($id)
    {
        try{
            $scf = Scf::where('employee_id', $id)->where('pip_required',1)->first();
            $pip = Pip::where('employee_id', $id)
                    ->latest()
                    ->first();
            $improments = json_decode($pip->improment_goals, true, 512, JSON_UNESCAPED_SLASHES);
            $improment = [];
            if (is_array($improments)) {
                foreach ($improments as $improment_goal) {
                    if ($improment_goal !== null) {
                        $improment[] = $improment_goal;
                    }
                }
            }
            $pip->improment = $improment;
            $managements = json_decode($pip->management_support);
            $management = [];
            if (is_array($managements)) {
                foreach ($managements as $manage) {
                    if ($manage !== null) {
                        $management[] = $manage;
                    }
                }
            }
            $pip->management = $management;
            $activi = json_decode($pip->activity);
            $activity = [];
            if (is_array($activi)) {
                foreach ($activi as $act) {
                    if ($act !== null) {
                        $activity[] = $act;
                    }
                }
            }
            $dates = json_decode($pip->check_point_date);
            $check_point_date = [];
            if (is_array($dates)) {
                foreach ($dates as $date) {
                    if ($date !== null) {
                        $check_point_date[] = $date;
                    }
                }
            }
            $follow_up = json_decode($pip->type_of_follow_up);
            $type_of_follow_up = [];
            if (is_array($follow_up)) {
                foreach ($follow_up as $follow) {
                    if ($follow !== null) {
                        $type_of_follow_up[] = $follow;
                    }
                }
            }
            $progress = json_decode($pip->progress_expected);
            $progress_expected = [];
            if (is_array($progress)) {
                foreach ($progress as $pro) {
                    if ($pro !== null) {
                        $progress_expected[] = $pro;
                    }
                }
            }
            $nts = json_decode($pip->notes);
            $notes = [];
            if (is_array($nts)) {
                foreach ($nts as $nt) {
                    if ($nt !== null) {
                        $notes[] = $nt;
                    }
                }
            }
            $progress_checkpoint = [];

            for ($i = 0; $i < count($activity); $i++) {
                $progress_checkpoint[] = [
                    'activity' => $activity[$i],
                    'check_point_date' => $check_point_date[$i],
                    'type_of_follow_up' => $type_of_follow_up[$i],
                    'progress_expected'=>$progress_expected[$i],
                    'notes'=>$notes[$i]
                ];
            }
            $pip->progress_checkpoint  = $progress_checkpoint ;
            
            unset(
                $pip->notes ,
                $pip->progress_expected ,
                $pip->type_of_follow_up ,
                $pip->activity ,
                $pip->check_point_date 
            );
           return response()->json(['data' => $pip]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to retrieve appraisal detail'], 500);
        }
    }
    public function pip_empolyeecomment(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer',
                // 'employee_ackn' => 'required',
                // 'employee_date'=>'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
        //$data = $request->comment;
            $pip = Pip::find($request->id);
            $pip->employee_ackn = $request->employee_ackn;
            $pip->employee_date = $request->employee_date;
            $pip->save();
            return response()->json(['data'=>$pip]);

        }catch (Exception $e){
            return response()->json(['error' => 'Failed to retrieve appraisal detail'], 500);
        }   
    }

    public function get_prf_review($id)
    {
        try{
            $prf = PprForm::where('employee_id', $id)
                    ->latest()
                    ->first();
           if ($prf === null) {
                    return response()->json(['data' => null], 200);
                }

            $object = json_decode($prf->objectives);
            $objectives = [];
            if (is_array($object)) {
                foreach ($object as $obj) {
                    if ($obj !== null) {
                        $objectives[] = $obj;
                    }
                }
            }
            $discussions = json_decode($prf->discussion_points);
            $discussion_points = [];
            if (is_array($discussions)) {
                foreach ($discussions as $discussion) {
                    if ($discussion !== null) {
                        $discussion_points[] = $discussion;
                    }
                }
            }
            //combained
            $objectives_discussion = [];
            for ($i = 0; $i < count($objectives); $i++) {
                $objectives_discussion[] = [
                    'objectives' => $objectives[$i],
                    'discussion_points' => $discussion_points[$i],
                ];
            }
            $prf->objectives_discussion = $objectives_discussion;
            //performance_review
            $performances = json_decode($prf->performance_review);
            $performance_r = [];
            if (is_array($performances)) {
                foreach ($performances as $performance) {
                    if ($performance !== null) {
                        $performance_review =    PerformanceReview::where('id',$performance)->pluck('performance_review')->first();
                        $performance_r[] = $performance_review;
                    }
                }
            }
            // dd($performance_r);
            $ratings = json_decode($prf->performance_review_rating);
            $performance_review_rating = [];
            if (is_array($ratings)) {
                foreach ($ratings as $rating) {
                    if ($rating !== null) {
                        $performance_review_rating[] = $rating;
                    }
                }
            }
            // $prf->performance_review_rating = $performance_review_rating;
            //combained
            $performance_reviews_data = [];
            for ($i = 0; $i < count($performance_r); $i++) {
                $performance_reviews_data[] = [
                    'performance' => $performance_r[$i],
                    'rating' => $performance_review_rating[$i],
                ];
            }
            $prf->performance_reviews = $performance_reviews_data; 

            unset(
                $prf->objectives,
                $prf->discussion_points,
                $prf->performance_review_rating,
                $prf->performance_review
            );
            return response()->json(['data' => $prf],200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to retrieve appraisal detail'], 500);
        }
    }
    public function prf_empolyeecomment(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer',
                
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            $prf = PprForm::find($request->id);
            $prf->employee_ack = $request->employee_ack;
            $prf->save();
            return response()->json(['data'=>$prf]);

        }catch (Exception $e){
            return response()->json(['error' => 'Failed to retrieve appraisal detail'], 500);
        }   
    }
}

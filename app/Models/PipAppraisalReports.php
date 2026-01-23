<?php

namespace App\Models;
use App\Models\Employee\Employees;
use App\Models\Masters\Appraisal_datas;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PipAppraisalReports extends Model
{
    use HasFactory;
    protected $table = "pip_appraisal_reports";
    protected $fillable = [
        'employee_id',
        'evaluation_date',
        'evaluation_type',
        'appraisal_data',
        'hod_rating',
        'hod_rating_avg_compt',
        'hod_rating_avg_chart',
        'principal_rating',
        'principal_rating_avg_compt',
        'principal_rating_avg_chart',
        'future_targets_data',
        'future_target_review_date',
        'future_targets_recommended',
        'training_title',
        'training_due_date',
        'training_recommended',
        'employee_comments',
        'hod_comments',
        'principal_comments',
        'status',
    ];
    public function employee()
    {
        return $this->hasOne(Employees::class, 'employee_id', 'employee_id');
    }
    public function appraisalData()
    {
        return $this->hasMany(Appraisal_datas::class,'appraisal_data', 'id');
    }
}

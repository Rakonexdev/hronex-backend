<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee\Employees;

class PprForm extends Model
{
    use HasFactory;
    protected $table = "ppr_forms";
    protected $fillable = [
        'employee_id','review_period','review_date','objectives',
        'discussion_points','performance_review','performance_review_rating',
        'performance_review_feedback','require_improvement','areas_improvement',
        'areas_discussion_points','work_environment','manager_action_points',
        'over_all_perfamance','appointment_conformed','no_conformed',
        'extension_period','probatinary_review','employee_ack',
        'hod_ack','principla_ack','ack_date'
    ];
    public function employee()
    {
        return $this->hasOne(Employees::class,'employee_id','employee_id');
    }
}

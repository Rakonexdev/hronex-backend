<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee\Employees;

class Pip extends Model
{
    use HasFactory;
    protected $table = "pips";
    protected $fillable = [
        'employee_id','date','staff_member',
        'area_of_concern','Observations','improment_goals','management_support',
        'activity','check_point_date','type_of_follow_up',
        'progress_expected','notes','employee_ackn','principal_ackn','employee_date','principal_date','pip_status'
    ];
    public function employee()
    {
        return $this->hasOne(Employees::class,'employee_id','employee_id');
    } 
}

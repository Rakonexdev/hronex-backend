<?php

namespace App\Models;

use App\Models\Employee\Employees;
use App\Models\Masters\Appraisal_datas;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppraisalReport extends Model
{
    use HasFactory;
    public function employee()
    {
        return $this->hasOne(Employees::class, 'employee_id', 'employee_id');
    }
    public function appraisalData()
    {
        return $this->hasMany(Appraisal_datas::class,'appraisal_data', 'id');
    }
}

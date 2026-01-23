<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee\Employees;

class Scf extends Model
{
    use HasFactory;
    protected $table = "scfs";
    protected $fillable = [
        'scf_date','concern_from_number','employee_id','staff_member','scf_data','scf_ans_data',
        'raising_concern','suggestions_made','breif_description','follow_up','comment','date_of_concern','slt_member','slt_member_ack'
        ,'pip_required'
    ];
    public function employee()
    {
        return $this->hasOne(Employees::class,'employee_id','employee_id');
    }
}

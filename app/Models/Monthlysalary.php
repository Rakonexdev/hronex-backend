<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee\Employees;

class Monthlysalary extends Model
{
    use HasFactory;
    protected $fillable = [
        'month_year',
        'employee_id', 
        'total_gross_salary', 
        'no_of_leave_days', 
        'total_leave_deduction_amount', 
        'total_addtional_amount', 
        'total_deduction_amount', 
        'net_salary', 
        'paid_reason',
        'remarks',
        'created_at',
        'entry_date'
    ];
    public function employee()
    {
        return $this->hasone(Employees::class,'employee_id','employee_id');
    }
    public function earning()
    {
        return $this->hasone(Earning::class,'employee_id','employee_id');
    }
    public function deduction()
    {
        return $this->hasone(Deduction::class,'employee_id','employee_id');
    }

}

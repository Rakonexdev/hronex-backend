<?php

namespace App\Models;

use App\Models\Employee\Employees;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deduction extends Model
{
    use HasFactory;

    protected $table = 'deductions';
    protected $fillable = [
        'employee_id', 'month_year', 'deduction_amount','deduction_reason','total_deduction_amount','remarks'
    ];
    public function employee()
    {
        return $this->hasone(Employees::class,'employee_id','employee_id');
    }
}

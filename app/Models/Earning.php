<?php

namespace App\Models;

use App\Models\Employee\Employees;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Earning extends Model
{
    use HasFactory;

    protected $table = 'earnings';
    protected $fillable = [
        'employee_id', 'month_year', 'additional_amount','additional_reason','total_addtional_amount','remarks'
    ];

    public function employee()
    {
        return $this->hasone(Employees::class,'employee_id','employee_id');
    }

}

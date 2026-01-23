<?php

namespace App\Models\Employee;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeePayrollInformation extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'employee_payroll_informations';
    protected $fillable = [
        'user_id',
        'basic_salary',
        'accomodation_allowance',
        'transport_allowance',
        'continuous_allowance',
        'temp_allowance',
        'other_allowance',
        'gross_total',
        'bank_name',
        'account_no',
        'iban_no',
        'salary_effective_from',
        'bank_docs',
        'status',
    ];

    public static $rules = [
        'user_id' => 'required',
        'basic_salary' => 'required|numeric|min:0',
        'accomodation_allowance' => 'required|numeric|min:0',
        'transport_allowance' => 'required|numeric|min:0',
        'continuous_allowance' => 'numeric|nullable|min:0',
        'temp_allowance' => 'numeric|nullable|min:0',
        'other_allowance' => 'numeric|nullable|min:0',
        'gross_total' => 'numeric|nullable|min:0',
        'bank_name' => 'string|nullable|max:255',
        'account_no' => 'string|nullable|max:255',
        'iban_no' => 'string|nullable|max:255',
        'bank_docs' => 'file|nullable|max:2048',
        'salary_effective_from' => 'date|nullable'
    ];

    protected $auditEvents = [
        'created',
        'updated',
        'deleted'
    ];

    public function employee()
    {
        return $this->belongsTo(Employees::class, 'user_id', 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
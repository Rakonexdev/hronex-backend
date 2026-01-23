<?php

namespace App\Models\Gratuity;

use App\Models\Employee\Employees;
use App\Models\Masters\Designation;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gratuity extends Model implements Auditable
{
    use HasFactory;

    use \OwenIt\Auditing\Auditable;
    protected $table = 'gratuity';

    protected $auditEvents = [
        'created',
        'updated',
        'deleted'
    ];

    protected $fillable = [
        'employee_id',
        'joining_date',
        'last_working_day',
        'notice_pay',
        'total_days_employment',
        'notice_period',
        'notice_period_remarks',
        'net_days_worked',
        'total_days_last_month',
        'current_month_salary',
        'eligible_days',
        'gratuity_add',
        'gratuity_ded',
        'gratuity_total',
        'annual_leave_entitled',
        'accrued_annual_leave',
        'annual_leave_availed',
        'annual_leave_balance',
        'leave_accrual_amount',
        'ticket_accrual_amount',
        'return_ticket_amount',
        'last_payroll_chk',
        'last_payroll',
        'net_pay',
        'net_pay_round_off',
        'active_decider',
        'status',
        'remarks'
    ];

    public static $rules = [
        'employee_id' => 'required|integer',
        'joining_date' => 'required',
        'last_working_day' => 'required',
        'notice_pay' => 'required',
        'total_days_employment' => 'required',
        'notice_period' => 'required',
        'notice_period_remarks' => 'required',
        'net_days_worked' => 'required',
        'current_month_salary' => 'required',
        'eligible_days' => 'required',
        'gratuity_add' => 'required',
        'gratuity_ded' => 'required',
        'gratuity_total' => 'required',
        'leave_accrual_amount' => 'required',
        'ticket_accrual_amount' => 'required',
        'return_ticket_amount' => 'required',
        'net_pay' => 'required',
        'net_pay_round_off' => 'required',
        'remarks' => 'required'
    ];

    public static $errmsgs = [
        'employee_id.required' => 'Please choose an employee',
        'joining_date.required' => 'Please choose joining date',
        'last_working_day.required' => 'Please mention last working day',
        'notice_pay.required' => 'Please enter notice pay',
        'total_days_employment.required' => 'Please enter total days of employment',
        'notice_period.required' => 'Please mention the notice period',
        'net_days_worked.required' => 'Please add net days worked',
        'current_month_salary.required' => 'Please input the current monthly salary',
        'eligible_days.required' => 'Eligible days are mandatory',
        'gratuity_add.required' => 'Gratuity amount is mandatory',
        'gratuity_ded.required' => 'Please input the gratuity deduction',
        'gratuity_total.required' => 'Gratuity Total is mandatory',
        'net_pay.required' => 'Net pay for the employee required',
        'net_pay_round_off.required' => 'Net pay round off required'
    ];

    protected $guarded = [];

    public function employee()
    {
        return $this->belongsTo(Employees::class);
    }

    public function resignations()
    {
        return $this->belongsTo(Resignations::class);
    }

    public function gratuitystatus()
    {
        return $this->hasOne(GratuityStatus::class, 'gratuity_id', 'id');
    }
}
<?php

namespace App\Models\Employee;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Employee\Employees;

class EmployeeStatus extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    protected $table = 'employee_status';

    protected $fillable = [
        'user_id',
        'employee_id',
        'current_status',
        'inactive_status',
        'inactive_date',
        'inactive_reason',
        'inactive_attachment',
        'created_by'
    ];

    public static $rules = [
        'user_id' => 'required|integer',
        'employee_id' => 'required|integer',
        'current_status' => 'required|integer',
        'inactive_status' => 'nullable|string',
        'inactive_date' => 'nullable|string',
        'inactive_reason' => 'nullable|string',
        'inactive_attachment' => 'nullable|file|mimes:pdf,docx,doc,xlsx,xls,txt,jpg,jpeg,png|max:2048',
        'created_by' => 'required|integer'
    ];

    protected $auditEvents = [
        'created',
        'updated',
        'deleted'
    ];

    public function employee()
    {
        return $this->belongsTo(Employees::class, 'employee_id', 'employee_id');
    }
    
}
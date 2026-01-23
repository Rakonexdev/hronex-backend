<?php

namespace App\Models\Leave;

use App\Models\Employee\Employees;
use App\Models\Employee\Attendance;
use App\Models\Masters\Designation;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeaveApplication extends Model implements Auditable
{
    use HasFactory;

    use \OwenIt\Auditing\Auditable;

    protected $auditEvents = [
        'created',
        'updated',
        'deleted'
    ];

    protected $fillable = [
        'leave_type',
        'employee_id',
        'date_from',
        'date_to',
        'time_from',
        'time_end',
        'no_days',
        'reason',
        'attachment',
        'forward_from',
        'forward_to',
        'created_by',
        'updated_by',
        'finalised',
        'amendment',
        'status',
        'academic_year'
    ];

    public function employee()
    {
        return $this->belongsTo(Employees::class);
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function leavetypes()
    {
        return $this->belongsTo(LeaveType::class, 'leave_type', 'id');
    }

    public function leaveapplicationstatus()
    {
        return $this->hasOne(LeaveApplicationStatus::class, 'leave_id', 'id');
    }

    public function attendancePercentage($id, $academic_year) {
        $from = $academic_year->start_from;
        $to = $academic_year->start_to;
        return Attendance::where('employee_id', $id)
            ->whereBetween('check_in', [$from, $to])
            ->get();
    }
   
}
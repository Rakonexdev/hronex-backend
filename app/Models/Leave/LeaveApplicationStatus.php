<?php

namespace App\Models\Leave;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class LeaveApplicationStatus extends Model implements Auditable
{
    use HasFactory;

    use \OwenIt\Auditing\Auditable;
    protected $table = 'leave_application_status';

    protected $auditEvents = [
        'created',
        'updated',
        'deleted'
    ];

    protected $fillable = [
        'leave_id',
        'applier_id',
        'approver_id',
        'leave_status',
        'comment',
        'assigned_to_role',
        'assigned_to_id'
    ];

    public function leaveApplication()
    {
        return $this->hasOne(LeaveApplication::class, 'id', 'leave_id');
    }
   // public function approverRole(){
       // return $this->hasOne(Roles::class,'approver_id','id');
   // }

    // public function leaveapplicationstatus()
    // {
    //     return $this->belongsTo(LeaveApplicationStatus::class, 'leave_id', 'id');
    // }

}
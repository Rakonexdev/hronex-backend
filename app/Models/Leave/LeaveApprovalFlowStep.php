<?php

namespace App\Models\Leave;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Leave\LeaveApprovalFlow;


class LeaveApprovalFlowStep extends Model implements Auditable
{
     use HasFactory;

    use \OwenIt\Auditing\Auditable;

    protected $auditEvents = [
        'created',
        'updated',
        'deleted'
    ];
    
    protected $fillable = [
        'leave_approval_flow_id',
        'role',
        'step_order'
    ];

    public function flow()
    {
        return $this->belongsTo(LeaveApprovalFlow::class);
    }
}

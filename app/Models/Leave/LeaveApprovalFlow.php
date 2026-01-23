<?php

namespace App\Models\Leave;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Leave\LeaveApprovalFlowStep;

class LeaveApprovalFlow extends Model implements Auditable
{
    use HasFactory;

    use \OwenIt\Auditing\Auditable;

    protected $auditEvents = [
        'created',
        'updated',
        'deleted'
    ];
    
    protected $fillable = ['name', 'department_id', 'description', 'is_active'];

    public function steps()
    {
        return $this->hasMany(LeaveApprovalFlowStep::class)->orderBy('step_order');
    }
}

<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MOEapprovalStatus extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    protected $table = 'moe_approval_status';

    protected $auditEvents = [
        'created',
        'updated',
        'deleted'
    ];
}
<?php

namespace App\Models\Masters;

use App\Models\Employee\Employees;
use App\Models\Leave\LeaveApplication;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Designation extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $auditEvents = [
        'created',
        'updated',
        'deleted'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employees::class);
    }

    public function leaveApplication()
    {
        return $this->hasMany(LeaveApplication::class);
    }
}
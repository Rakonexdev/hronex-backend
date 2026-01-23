<?php

namespace App\Models\Leave;

use App\Models\Leave\LeaveApplication;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeaveType extends Model
{
    use HasFactory;

    public function leaveApplication()
    {
        return $this->hasOne(LeaveApplication::class, 'leave_type', 'id');
    }
}
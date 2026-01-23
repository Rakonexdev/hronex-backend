<?php

namespace App\Models\Employee;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmergencyDetails extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    protected $table = 'employee_emergency_details';

    protected $fillable = [
        'user_id',
        'emergency_primary_name',
        'relationship_primary',
        'emergency_primary_contact',
        'emergency_secondary_name',
        'relationship_secondary',
        'emergency_secondary_contact',
        'comment',
        'status',
    ];

    public static $rules = [
        'user_id' => 'required|integer',
        'emergency_primary_name' => 'required|string|max:100',
        'relationship_primary' => 'required|integer',
        'emergency_primary_contact' => 'required|integer',
        'emergency_secondary_name' => 'nullable|string|max:100',
        'relationship_secondary' => 'nullable|integer',
        'emergency_secondary_contact' => 'nullable|string|max:100',
        'comment' => 'nullable|string',
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
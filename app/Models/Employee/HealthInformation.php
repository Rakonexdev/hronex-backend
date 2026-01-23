<?php

namespace App\Models\Employee;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HealthInformation extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    protected $table = 'employee_health_informations';

    protected $fillable = [
        'user_id',
        'hmc_card_no',
        'hmc_card_atch',
        'health_insurance_status',
        'health_insurance_atch',
        'health_insurance_name',
        'blood_group',
        'medical_ailment_physical',
        'physical_details',
        'medical_ailment_mental',
        'mental_details',
        'medication_details',
        'status',
    ];

    public static $rules = [
        'user_id' => 'required|integer',
        'hmc_card_no' => 'nullable|string|max:50',
        'hmc_card_atch' => 'nullable|file',
        'health_insurance_status' => 'nullable|string|max:25',
        'health_insurance_atch' => 'nullable|file',
        'health_insurance_name' => 'nullable|string|max:100',
        'blood_group' => 'nullable|string|max:50',
        'medical_ailment_physical' => 'nullable|max:25',
        'medical_ailment_mental' => 'nullable|max:25',
        'medication_details' => 'nullable|max:100',
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
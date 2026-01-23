<?php

namespace App\Models\Employee;

use App\Models\Employee\Employees;
use App\Models\Masters\Designation;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\Gratuity\Gratuity;

class Resignations extends Model implements Auditable
{
    use HasFactory;

    use \OwenIt\Auditing\Auditable;
    protected $table = 'resign_applications';

    protected $auditEvents = [
        'created',
        'updated',
        'deleted'
    ];

    protected $fillable = [
        
    ];

    public function employee()
    {
        return $this->belongsTo(Employees::class);
    }

    public function gratuity()
    {
        return $this->hasOne(Gratuity::class, 'employee_id', 'employee_id');
    }
}
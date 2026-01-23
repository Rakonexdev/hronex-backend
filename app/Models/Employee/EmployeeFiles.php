<?php

namespace App\Models\Employee;

use App\Models\User;
use App\Models\Employee\Employees;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeFiles extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'employee_files';
    protected $fillable = [
        'user_id',
        'file_data',
        'file_type',
        'file_path',
        'created_by',
        'updated_by',
        'active',
    ];

    public static $rules = [        
        'file_data' => 'required|string',
        'file_type' => 'required|string|max:100'
    ];

    protected $auditEvents = [
        'created',
        'updated',
        'deleted'
    ];

     protected $casts = [
        'file_data' => 'json',
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
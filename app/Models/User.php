<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements Auditable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;
    use \OwenIt\Auditing\Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'password',
        'is_admin',
        'avatar',
        'device_token'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $auditEvents = [
        'created',
        'updated',
        'deleted'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function user_device_token()
    {
        return $this->hasMany(UserDeviceToken::class, 'user_id', 'id');
    }

    public function employee()
    {
        return $this->hasOne(Employee\Employees::class);
    }

    public function employee_emergency()
    {
        return $this->hasOne(Employee\EmergencyDetails::class);
    }

    public function employee_payroll_info()
    {
        return $this->hasOne(Employee\EmployeePayrollInformation::class);
    }

    public function health_information()
    {
        return $this->hasOne(Employee\HealthInformation::class);
    }

}

<?php

namespace App\Models\Employee;

use App\Models\AppraisalReport;
use App\Models\User;

use App\Models\Earning;
use Carbon\CarbonPeriod;
use App\Models\Deduction;
use App\Models\Departmentt;
use App\Models\EmpolyeeDepartment;
use App\Models\Masters\Department;
use App\Models\Masters\Designation;
use App\Models\Leave\LeaveApplication;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\Employee\EmergencyDetails;
use App\Models\Monthlysalary;
use App\Models\Gratuity\Gratuity;
use App\Models\Employee\Resignations;
use App\Models\Employee\Attendance;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Employee\EmployeeStatus;
use App\Models\Employee\EmployeeFiles;
use App\Models\Scf;
use App\Models\PprForm;
use App\Models\Pip;
use App\Models\PipAppraisalReports;


class Employees extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'user_id',
        'employee_id',
        'employee_no',
        'employee_type',
        'name',
        'lname',
        'gender',
        'dob',
        'age',
        'email',
        'nationality',
        'marital_status',
        'mobile1_code',
        'mobile1',
        'mobile2_code',
        'mobile2',
        'qidno',
        'qidexpiry',
        'qid_attaches',
        'passportno',
        'passportexpiry',
        'passport_attaches',
        'joiningdate',
        'department',
        'designation',
        'school_shift',
        'end_probation',
        'contract_type',
        'contract_length',
        'end_contract',
        'service_years',
        'hrcomment',
        'sponsorship_status',
        'fas_sponsor',
        'fas_spo_date',
        'tkt_allowance_dur',
        'relevant_degree',
        'degree_details',
        'degree_attaches',
        'degree_attest_status',
        'other_qualifications',
        'disclaimer_ltr_moe',
        'disclaimer_ltr_moe_atch',
        'declaration_ltr_moe',
        'declaration_ltr_moe_atch',
        'moe_approval_status',
        'police_clearance_issuance',
        'police_clearance_atch',
        'noc',
        'noc_atch',
        'experience_letter',
        'experience_letter_atch',
        'status'
    ];

    public static $rules = [
        'user_id' => 'max:255',
        'employee_id' => 'required|string|max:255',
        'employee_no' => 'required|employee_no|unique:employees,employee_no',
        'name' => 'required|string|max:255',
        /*'lname' => 'required|string|max:255',*/
        'gender' => 'required|string|max:255',
        'dob' => 'required|date',
        'age' => 'nullable|integer',
        'email' => 'required|email|unique:users,email',
        'nationality' => 'required|string|max:255',
        'marital_status' => 'required|string|max:255',
        'mobile1_code' => '|max:255',
        'mobile1' => 'required|string|max:255',
        'mobile2_code' => 'nullable|max:255',
        'mobile2' => 'nullable|string|max:255',
        'qidno' => 'required|max:255|unique:employees,qidno',
        'qidexpiry' => 'required|date',
        'passportno' => 'nullable|string|max:255|unique:employees,passportno',
        'passportexpiry' => 'nullable|date',
        'joiningdate' => 'required|date',
        'department' => 'required|integer|max:255',
        'designation' => 'required|integer|max:255',
        'school_shift' => 'required|integer|max:255',
        'end_probation' => 'nullable|date',
        'contract_type' => 'required|integer|max:255',
        'contract_length' => 'required|string',
        'end_contract' => 'nullable|date',
        'service_years' => 'nullable|string',
        'hrcomment' => 'nullable|string|max:255',
        'sponsorship_status' => 'required|string|max:255',
        'fas_sponsor' => 'nullable|string|max:255',
        'fas_spo_date' => 'nullable|date',
        'tkt_allowance_dur' => 'nullable|integer|min:0',
        'relevant_degree' => 'required|string|max:255',
        'degree_attest_status' => 'nullable|string|max:255',
        'disclaimer_ltr_moe' => 'nullable|string|max:255',
        'declaration_ltr_moe' => 'nullable|string|max:255',
        'declaration_ltr_moe_atch' => 'nullable',
        'moe_approval_status' => 'nullable|integer|max:255',
        'police_clearance_issuance' => 'nullable|string|max:255',
        'police_clearance_atch' => 'nullable|string|max:255',
        'noc' => 'nullable|string|max:255',
        'experience_letter' => 'nullable|string|max:255',
        'experience_letter_atch' => 'nullable|string|max:255',
        'other_qualifications' => 'nullable',
        'status' => 'max:255'
    ];

    public static $main_rules = [
        'user_id' => 'max:255',
        'employee_id' => 'required|string|max:255',
        'name' => 'required|string|max:255',
        /*'lname' => 'required|string|max:255',*/
        'gender' => 'required|string|max:255',
        'dob' => 'required|date',
        'age' => 'required|integer',
        'email' => 'required|email|unique:users,email',
        'nationality' => 'required|string|max:255',
        'marital_status' => 'required|string|max:255',
        'mobile1_code' => '|max:255',
        'mobile1' => 'required|string|max:255',
        'mobile2_code' => 'nullable|max:255',
        'mobile2' => 'nullable|string|max:255',
        'qidno' => 'required|max:255|unique:employees,qidno',
        'qidexpiry' => 'required|date',
        'passportno' => 'required|string|max:255|unique:employees,passportno',
        'passportexpiry' => 'required|date',        
        'status' => 'max:255'
    ];

    public static $other_rules = [        
        'joiningdate' => 'required|date',
        'department' => 'required|integer|max:255',
        'designation' => 'required|integer|max:255',
        'school_shift' => 'required|integer|max:255',
        'end_probation' => 'nullable|date',
        'contract_type' => 'required|integer|max:255',
        'contract_length' => 'required|string',
        'end_contract' => 'nullable|date',
        'service_years' => 'nullable|string',
        'hrcomment' => 'nullable|string|max:255',
        'sponsorship_status' => 'required|string|max:255',
        'fas_sponsor' => 'nullable|string|max:255',
        'fas_spo_date' => 'nullable|date',
        'tkt_allowance_dur' => 'nullable|integer|min:0',
        'relevant_degree' => 'required|string|max:255',
        'degree_attest_status' => 'nullable|string|max:255'
    ];

    protected $auditEvents = [
        'created',
        'updated',
        'deleted'
    ];

    public function emergencyDetails()
    {
        return $this->hasOne(EmergencyDetails::class, 'user_id', 'user_id');
    }

    public function healthInformation()
    {
        return $this->hasOne(HealthInformation::class, 'user_id', 'user_id');
    }

    public function employeePayrollInformation()
    {
        return $this->hasMany(EmployeePayrollInformation::class, 'user_id', 'user_id');
    }

    public function employeeFiles()
    {
        return $this->hasMany(EmployeeFiles::class, 'user_id', 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function employeeDepartment()
    {
        return $this->hasone(Department::class,'id','department');
    }
    public function employeeEarnings()
    {
        return $this->hasone(Earning::class,'employee_id','employee_id');
    }
    public function employeeDeduction()
    {
        return $this->hasone(Deduction::class,'employee_id','employee_id');
    }

    public function leaveApplication()
    {
        return $this->belongsTo(LeaveApplication::class,'employee_id','employee_id');
    }

    public function designations()
    {
        return $this->hasOne(Designation::class, 'id', 'designation');
    }

    public function departments()
    {
        return $this->hasOne(Department::class, 'id', 'department');
    }


    public function monthlysalary()
    {
        return $this->hasOne(Monthlysalary::class, 'employee_id', 'employee_id');
    }


    public function sickLeaves()
    {
        return $this->hasMany(LeaveApplication::class);
    }

    public function takeSickLeave($startDate, $endDate)
    {
        $firstThreeMonths = now()->diffInMonths($this->joiningdate) <= 3;
        $isDuringAcademicYear = now()->between('2023-08-01', '2024-06-30');

        if ($firstThreeMonths || !$isDuringAcademicYear) {
            return false;
        }

        $days = CarbonPeriod::create($startDate, $endDate)->count() + 1;
        $sickLeave = new LeaveApplication([
            'start_date' => $startDate,
            'end_date' => $endDate,
            'days' => $days,
        ]);

        $this->sickLeaves()->save($sickLeave);

        return true;
    }


    public function gratuity()
    {
        return $this->hasOne(Gratuity::class, 'employee_id', 'employee_id');
    }

    public function resignations()
    {
        return $this->hasOne(Resignations::class, 'employee_id', 'employee_id');
    }

    public function appraisalreprot()
    {
        return $this->hasOne(AppraisalReport::class, 'employee_id', 'employee_id');
    }
       public function pipappraisalreport()
    {
        return $this->hasOne(PipAppraisalReports::class, 'employee_id', 'employee_id');
    }
    public function attendance()
    {
        return $this->hasMany(Attendance::class,'employee_id', 'employee_id');
    }
    public function employeeStatus()
    {
        return $this->hasone(EmployeeStatus::class,'employee_id','employee_id');
    }
   public function scf()
   {
    return $this->hasOne(Scf::class,'employee_id','employee_id');
   }
   public function ppr()
   {
    return $this->hasOne(PprForm::class,'employee_id','employee_id');
   }
   public function pip()
   {
    return $this->hasOne(Pip::class,'employee_id','employee_id');
   }
}

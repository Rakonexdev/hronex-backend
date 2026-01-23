<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Employee\Employees;
use App\Models\Employee\EmergencyDetails;
use App\Models\Employee\EmployeePayrollInformation;
use App\Models\Employee\HealthInformation;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Str;
use Carbon\Carbon;
use DateTime;

class UserImport implements ToModel, SkipsEmptyRows, WithHeadingRow, WithValidation
{
    use Importable;

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
            ],
            'email' => [
                'required',
                'unique:users',
            ],
        ];
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Check if the row is empty
        if (empty(array_filter($row))) {
            return null;
        }

        /*User data import*/
        $user = User::create([
               'name' => $row['name'],
               'email'    => $row['email'],
               'password' => \Hash::make($row['password'])
        ]); 

        /*Employee data import: Main table*/   
        $row['user_id'] = $user->id;        
        $row['lname'] = $row['lname'];
        $row['dob'] = $this->transformDate($row['dob']);
        $row['joiningdate'] = $this->transformDate($row['joiningdate']);
        $row['age'] = Carbon::parse($row['dob'])->diff($row['joiningdate'])->format('%y');
        $row['qidexpiry'] = $this->transformDate($row['qidexpiry']);
        $row['passportexpiry'] = $this->transformDate($row['passportexpiry']);        
        $row['end_probation'] = Carbon::parse($row['joiningdate'])->addDays(371);
        $row['end_contract'] = $this->transformDate($row['end_contract']);
        //$row['service_years'] = Carbon::parse($row['joiningdate'])->diff($row['end_contract'])->format('%y');
        $row['other_qualifications'] = (!empty($row['other_qualifications']))?serialize(array($row['other_qualifications'])):NULL;

        $employees = Employees::create($row); 

        /*Update the employee_id(additional) column after insertion*/
        $employees_update = Employees::where('user_id', $user->id)->first();
        $employees_update->update(['employee_id' => $employees->id]); 

        /*Employee emergency data */        
        $employees_emergency = EmergencyDetails::create($row); 

        /*Employee payroll data */        
        $employees_payroll = EmployeePayrollInformation::create($row); 

        /*Employee health info */        
        $row['physical_details'] = (!empty($row['physical_details']))?serialize(array($row['physical_details'])):NULL;        
        $row['mental_details'] = (!empty($row['mental_details']))?serialize(array($row['mental_details'])):NULL;  

        $employees_health = HealthInformation::create($row);     

        /*Role assigning to new users*/
        if(1 == $row['department']){
            $user->assignRole('Employee');
        }else{
            if(16 == $row['designation']){
                $user->assignRole('Principal');
            }else if(17 == $row['designation']){
                $user->assignRole('Vp');
            }else if(20 == $row['designation']){
                $user->assignRole('Accounts');
            }else if(22 == $row['designation'] || 26 == $row['designation']){
                $user->assignRole('Hr');
            }
        }

        return $employees;        
    }

    /**
     * Transform a date value into a Carbon object.
     *
     * @return \Carbon\Carbon|null
     */
    public function transformDate($value, $format = 'Y-m-d')
    {
        try {
            return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
        } catch (\ErrorException $e) {
            return \Carbon\Carbon::createFromFormat($format, $value);
        }
    }
    
}

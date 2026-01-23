<?php

namespace App\Exports;
use App\Models\Employee\Employees;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeeExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $employees;

    public function __construct($employees)
    {
        $this->employees = $employees;
    }
    public function collection()
    {
        //
        return $this->employees;
    }
    public function headings(): array
    {
        return [
            'Name',
            'Last Name',
            'Emp.No.',
            'Email',
            'Department',
            'Designation',
            'Gender',
            'Dob',
            'Age',
            'Nationality',
            'Marital Status',     
            'Mobile 1',
            'Mobile 2',
            'Qid No',
            'Qid Expiry',
            'Passport No',
            'Passport Expiry',
            'Joining Date',
            'School Shift',
            'End Probation',
            'Contract Type',
            'Contract Length',
            'End Contract',
            'Service Years',
            'Sponsorship Status',
            'Basic Salary',
            'Accomodation Allowance',
            'Transport Allowance',
            'Other Allowance',
            'Gross Total',
            'Bank Name',
            'Account No',
            'Iban No'
        ];
    }
}

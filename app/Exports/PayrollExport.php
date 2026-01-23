<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PayrollExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $payroll_details;

    public function __construct($payroll_details)
    {
        $this->payroll_details = $payroll_details;
    }
    public function collection()
    {
        //
        return $this->payroll_details;
    }
    public function headings(): array
    {
        return [
            'Emp Name',
            'Joining Date',
            'Designations',
            'Basic',
            'Gross',
            'Others',
            'Total',
            'Gratuity',
            'Additional',
            'Total',
            'Deduction',
            'Final',
            'Final without Round',
            'Dept',
            'IBAN',
            'Remarks'
        ];
    }
}

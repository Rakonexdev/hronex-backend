<?php

namespace App\Exports;
//use Maatwebsite\Excel\Concerns\FromCollection;
//use Maatwebsite\Excel\Concerns\WithHeadings;
//use Maatwebsite\Excel\Concerns\ShouldAutoSize;
//use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
//use PhpOffice\PhpSpreadsheet\Style\Fill;
//use Maatwebsite\Excel\Concerns\WithStyles;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class EmployeeTimesheetExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $leave_data;

    public function __construct($data, $dates)
    {
        $this->data = $data;
        $this->dates = $dates;
    }

    public function collection()
    {        
        return collect($this->data);
    }
    
    public function view(): View
    {        
        $employees = $this->data;
        $dates = $this->dates;
        
        return view('reports.employee_timesheet_excel', compact('employees', 'dates'));
    }

}

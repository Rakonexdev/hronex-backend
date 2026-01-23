<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\WithStyles;

class MonthlyLeavesExport implements FromCollection, WithHeadings,
ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $leave_data;

    public function __construct($leave_data)
    {
        $this->leave_data = $leave_data;
    }
    public function collection()
    {        
        return collect($this->leave_data);
    }
    public function headings(): array
    {
        return [
            'Employee #',
            'Name',
            'Leave Type',
            'Start Date',
            'End Date',
            'Time From',
            'Time End',
            'Days',
            'Unpaid',
            'Comments'
            /*'Paid Status'*/
        ];
    }
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'd8d8d8']]], // Apply bold font & color to the first row  
                      
            /*'A' => ['fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFFF0000']]], // Apply red color to column A
            */
        ];
    }
}

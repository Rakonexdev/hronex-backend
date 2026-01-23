<?php

namespace App\Exports;
use Carbon\Carbon;
use App\Models\Employee\Employees;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TimesheetExport implements FromCollection, WithHeadings
{
    private $attendance;
    private $dates;


    public function __construct($attendance, $dates)
{
    $this->attendance = $attendance;
    $this->dates = $dates;
}



    public function collection()
{
    $formattedAttendance = $this->formatAttendanceData();

    $exportData = [];

    foreach ($formattedAttendance as $record) {
        $row = [
            'Name' => $record['name'],
        ];

        /*foreach ($this->dates as $date) {
            $row[$date] = isset($record['attendance'][$date]) && $record['attendance'][$date] === 'H' ? 'H' : '';
        }
*/
        foreach ($this->dates as $date) {
            $attendanceValue = isset($record['attendance'][$date]) ? $record['attendance'][$date] : '';
            $row[$date] = $attendanceValue;
        }
        $exportData[] = $row;
    }

    return collect($exportData);
}


    public function headings(): array
    {
        $headings = ['Name'];

        foreach ($this->dates as $date) {
            $headings[] = $date;
        }

        return $headings;
    }

   /* private function formatAttendanceData()
    {
        $formattedAttendance = [];
        $currentYear = Carbon::now()->format('Y');
        $currentMonth = Carbon::now()->format('m');
    
        foreach ($this->attendance as $record) {
            $formattedRecord = [
                'name' => $record['name'],
                'attendance' => []
            ];
    
            // Process check-in data
            if (isset($record['attendance'])) {
                $attendanceData = $record['attendance'];
                // dd($attendanceData);
                foreach ($this->dates as $date) {
                    $checkin = isset($attendanceData[$date]) && $attendanceData[$date] === 'P' ? 'H' : '';
                    $leave = isset($record['attendance'][$date]) && $record['attendance'][$date] === 'L' ? 'L' : '';
                    // $formattedRecord['attendance'][$date] = $checkin;
                    // dd($formattedRecord);

                    $formattedRecord['attendance'][$date] = $checkin ? ($leave ? 'HD' : 'H') : ($leave ? 'L' : '');
                }
            }
            
            $formattedAttendance[] = $formattedRecord;
            // dd($formattedAttendance);
        }
    
        return $formattedAttendance;
    }
    */
    private function formatAttendanceData()
{
    $formattedAttendance = [];

    foreach ($this->attendance as $record) {
        $formattedRecord = [
            'name' => $record['name'],
            'attendance' => []
        ];

    
        foreach ($this->dates as $date) {
            $checkin = isset($record['attendance'][$date]['checkin']) ? $record['attendance'][$date]['checkin'] : '';
            $leave = isset($record['attendance'][$date]['leave']) ? $record['attendance'][$date]['leave'] : '';

            $attendanceValue = ($checkin && $leave) ? 'HD' : ($checkin ? 'H' : ($leave ? 'L' : ''));
            $formattedRecord['attendance'][$date] = $attendanceValue;
        }

        $formattedAttendance[] = $formattedRecord;
      
    }

    return $formattedAttendance;
}

    
    
    
}


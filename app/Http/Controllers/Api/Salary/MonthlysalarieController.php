<?php

namespace App\Http\Controllers\Api\Salary;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Monthlysalary;
use Illuminate\Support\Facades\Validator;
use Dompdf\Dompdf;
use App\Models\Employee\Employees;
use App\Models\Gratuity\Gratuity;
use Illuminate\Support\Facades\Storage;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

class MonthlysalarieController extends Controller
{
    //

    public function generatePayslip($employee_id, $month_year)
    {
        // Retrieve employee and payslip data
        $employee = Employees::find($employee_id);
        $payslip = $this->retrievePayslipData($employee_id, $month_year);
     
        $dompdf = new Dompdf();
        //$html = view('hr_payroll.pay_slip_pdf', compact('payslip'))->render();
        //dd($html);
        //$dompdf->loadHtml(view('hr_payroll.pay_slip_pdf', compact('payslip'))->render());
        $dompdf->loadHtml($payslip);
        //$dompdf->loadHtml($inlinedHtml);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        //$dompdf->stream();
        $fileName = 'payslip-' . $employee_id . '.pdf';
        $filePath = 'uploads/payslip/' . date('F') . '/' . $fileName;
    
        Storage::disk('public')->put($filePath, $dompdf->output());
    
        return $filePath;
    }
    
    private function retrievePayslipData($employee_id, $month_year)
    {
        // Query and process the payslip data
        $payslip = Monthlysalary::with(['employee', 
                                        'employee.designations', 
                                        'employee.employeePayrollInformation' => function ($query) {
                                                                    $query->orderBy('id', 'desc')->take(1);
                                                                }, 
                                        'earning', 
                                        'deduction'])
            ->where('month_year', 'like', '%' . $month_year . '%')
            ->where('employee_id', $employee_id)
            ->get();
        if ($payslip->isEmpty()) {
            return response()->json(['error' => 'No payslip found'], 404);
        }
        if (1 == $payslip[0]->is_gratuity) {
            $gratuity = Gratuity::with('gratuitystatus')->where('employee_id', $employee_id)->first();
            return view('hr_payroll.pay_slip_gratuity', compact('payslip', 'gratuity'))->render();
        } else {
            //dd($payslip);
            return view('hr_payroll.pay_slip_pdf', compact('payslip'))->render();
        }
        
       // return $payslip;
    }
    public function getPayslip(Request $request)
{
    try {
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required|integer',
            'month' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $employee_id = $request->input('employee_id');
        $month = $request->input('month');
        $month_year = date('F-Y', strtotime($month));

        $payslip = Monthlysalary::with(['employee', 
                                        'employee.designations', 
                                        'employee.employeePayrollInformation' => function ($query) {
                                                                    $query->orderBy('id', 'desc')->take(1);
                                                                }, 
                                        'earning', 
                                        'deduction'])
            ->where('month_year', 'like', '%' . $month_year . '%')
            ->where('employee_id', $employee_id)
            ->get();

        if ($payslip->isEmpty()) {
            return response()->json(['error' => 'No payslip found'], 404);
        }

        // Generate PDF and get file path
        $filePath = $this->generatePayslip($employee_id, $month_year);
        /*$localUrl = "http://localhost/fas_hrm/storage/";      

        $fullUrl = $localUrl . $filePath;*/

        return response()->json(['payslip' => $payslip, 'pdf_path' => $filePath]);
    } catch (Exception $e) {
        return response()->json(['error' => 'Failed to retrieve payslip'], 500);
    }
}
}

<html>
<head>
    <meta charset="UTF-8" />
    <title>Final Settlement Sheet</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" />   
    <!-- <link rel="stylesheet" href="{{asset('css/report.css')}}" /> -->

    <style>
    table,tr,th,td{
        border: 1px solid;
        padding: 10px 10px 10px 10px;
        text-align: center;
    }
</style>
</head>
<body>
        <?php
        $lastWorkingDay = $gratiuity->last_working_day;
        $difference = getDateDifference($lastWorkingDay);
        /* $day = (int)substr($lastWorkingDay, 8, 2);
        if($day> 25){
            $difference = $day-25;
        } */
        ?>

        <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>

        <main id="main" class="main">            
            <div class="align-item-center" style="display:flex; justify-content:center;align-items: center;">
                <table id="tbl_exporttable_to_xls">
                    <thead>
                        <tr>
                            <th colspan="11"><img src="{{ asset('img/FAS Logo.png') }}" alt="" class="inv-logo" alt="" style="max-height: 50px;"></th>
                        </tr>
                        <tr>
                            <th colspan="11" style="background-color:#44546a;color:#FFF;"><h4>STATEMENT OF FULL AND FINAL SETTLEMENT</h4></th>
                        </tr>
                        <tr>
                            <th colspan="5"></th>
                            <th colspan="4"><h6>LEAVES</h6></th>
                        </tr>
                        <tr>
                            <th colspan="2"></th>
                            <th colspan="3"></th>
                            <th style="background-color: #D8D8D8;">Type Of Leave</th>
                            <th style="background-color: #D8D8D8;">Eligibility</th>
                            <th style="background-color: #D8D8D8;">Availed</th>
                            <th style="background-color: #D8D8D8;">Balance leaveDays</th>
                        </tr>
                        <tr>
                            <th colspan="2">Name of the Employee</th>
                            <td colspan="3">{{$gratiuity->name}} &nbsp;{{$gratiuity->lname}}</td>
                            <td>Annual Leave ( per annum)</td>
                            <td>{{$gratiuity->annual_leave_entitled}}</td>
                            <td>{{$gratiuity->annual_leave_availed}}</td>
                            <td>{{$gratiuity->annual_leave_balance}}</td>
                        </tr>
                        <tr>
                            <th>Employee Number / Designation</th>
                            <td >{{$gratiuity->employee_no}}</td>
                            <td colspan="3">{{$gratiuity->designation}}</td>
                            <td>Accured Annual Leave</td>
                            <td>{{$gratiuity->accrued_annual_leave}}</td>
                            <td>{{$gratiuity->annual_leave_availed}}</td>
                            <td>{{$gratiuity->annual_leave_balance}}</td>
                        </tr>
                        <tr>
                            <th colspan="2">QID Number</th>
                            <td colspan="3">{{$gratiuity->qidno}}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th colspan="2">Passport Number</th>
                            <td colspan="3">{{$gratiuity->passportno}}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th colspan="2">Nationality</th>
                            <td colspan="3">{{$gratiuity->country_name}}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th colspan="2">Detail Salary</th>
                            <td style="background-color: #D8D8D8;">BASIC</td>
                            <td style="background-color: #D8D8D8;">Housing</td>
                            <td style="background-color: #D8D8D8;">TRANSP</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th colspan="2"></th>
                            <td>{{$gratiuity->basic_salary}}</td>
                            <td>{{$gratiuity->accomodation_allowance}}</td>
                            <td>{{$gratiuity->transport_allowance}}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th colspan="2">Total Salary </th>
                            <td colspan="3">{{$gratiuity->gross_total}}</td>
                        
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th colspan="2">Date of Joining </th>
                            <td colspan="3"><strong>{{Carbon\Carbon::parse($gratiuity->joining_date)->format('d-M-y')}}</strong></td>
                        
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th colspan="2">Last Working Day </th>
                            <td colspan="3"><strong>{{Carbon\Carbon::parse($gratiuity->last_working_day)->format('d-M-y')}}</strong></td>
                        
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th colspan="2">Total Number of days Worked </th>
                            <td colspan="3">{{$gratiuity->total_days_employment}}</td>
                        
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th colspan="2">Total Leave Without Pay </th>
                            <td colspan="3">0</td>
                        
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th colspan="2">Net Days worked </th>
                            <td colspan="3">{{$gratiuity->net_days_worked}}</td>
                        
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th colspan="11" style="background-color: #D8D8D8;">Final Benefits</th>
                        </tr>
                        <tr>
                            <th colspan="2">Particulars</th>
                            <td colspan="5"></td>
                            <td><strong>Days</strong></td>
                            <td><strong>Amount</strong></td>
                        </tr>
                        <tr>
                            <th colspan="2"></th>
                            <td colspan="5"></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th colspan="2">Total Gratuity</th>
                            <td colspan="5"></td>
                            <td></td>
                            <td>{{$gratiuity->gratuity_total}}</td>
                        </tr>
                        <tr>
                            <th colspan="2">Gratuity Deduction</th>
                            <td colspan="5"></td>
                            <td></td>
                            <td>{{$gratiuity->gratuity_ded}}</td>
                        </tr>
                        <tr>
                            <th colspan="2">Gratuity Paid</th>
                            <td colspan="5"></td>
                            <td></td>
                            <td>{{$gratiuity->gratuity_add}}</td>
                        </tr>
                        <tr>
                            <th colspan="2">Notice period served</th>
                            <td colspan="5"></td>
                            <td></td>
                            <td>{{$gratiuity->notice_period}}</td>
                        </tr>
                        <tr>
                            <th colspan="2">Leave Acrual</th>
                            <td colspan="5"></td>
                            <td></td>
                            <td>{{$gratiuity->leave_accrual_amount}}</td>
                        </tr>
                        <tr>
                            <th colspan="2">Additional Allowance </th>
                            <td colspan="5"> 
                                @if(!empty($difference))
                                    {{$difference}} days salary from 26-{{date('M', strtotime($lastWorkingDay))}} to {{date('d-M', strtotime($lastWorkingDay))}}
                            @endif 
                            </td>
                            <td>{{$difference}}</td>
                            <td>{{$gratiuity->current_month_salary}}</td>
                        </tr>
                        <tr>
                            <th colspan="2">Ticket  Allowance </th>
                            <td colspan="5"></td>
                            <td></td>
                            <td>{{$gratiuity->ticket_accrual_amount}}</td>
                        </tr>
                        <tr style="background-color: #D8D8D8;">
                            <th colspan="7" >Total Final Benefits </th>
                            <td></td>
                            <td><strong>{{number_format(($gratiuity->net_pay+$gratiuity->last_payroll), 2)}}</strong></td>
                        </tr>
                        <tr>
                            <th colspan="2">Remarks: </th>
                            <td colspan="7">
                                @if(1==$gratiuity->last_payroll_chk)
                                    Notice pay[ Last payroll included ]
                                    +
                                @endif
                                    Gratuity 
                                    + 
                                @if(!empty($difference))
                                    {{$difference}} days salary from 26-{{date('M', strtotime($lastWorkingDay))}} to {{date('d-M', strtotime($lastWorkingDay))}}
                                @endif <br />
                                {!!$gratiuity->remarks!!}
                            </td>
                            
                        </tr>
                        <tr>
                            <th colspan="3"></th>
                            <td colspan="3"></td>
                            <td colspan="3"></td>
                        </tr>
                        <tr style="background-color: #D8D8D8;font-weight:bold;">
                            <th colspan="3">HR Officer</th>
                            <td colspan="3">Principal</td>
                            <td colspan="3">Employee's signature</td>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="row py-2">
                <div style='display:flex;justify-content:center;'>
                    <button type="button" class="btn btn-success" onclick="ExportToExcel('xlsx')">Download Excel</button>
                </div>
            </div>
        </main>

        <!-- jQuery -->
    <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Report excel -->
    <script src="{{ asset('js/export.js') }}"></script>

    <script>

        function ExportToExcel(type, fn, dl) {
            // alert("hs");
            var elt = document.getElementById('tbl_exporttable_to_xls');
            var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
            return dl ?
                XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }) :
                XLSX.writeFile(wb, fn || ('STATEMENT OF FULL AND FINAL SETTLEMENT.' + (type || 'xlsx')));
        }

    </script>

</body>
</html>
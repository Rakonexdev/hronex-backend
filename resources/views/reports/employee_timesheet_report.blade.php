@php
$cnt = 0;
$cntl = 0;
$monthS = '';
$monthL = '';
$yearS = '';
$yearL = '';
for($i=1; $i<count($dates); $i++){    
    if($dates[$i]['month'] != $dates[$i-1]['month']){
        $cnt = $i; 
        $monthS = $dates[$i-1]['month'];
        $monthL = $dates[$i]['month'];
        $yearS = date('Y', strtotime($dates[$i-1]['date']));
        $yearL = date('Y', strtotime($dates[$i]['date']));
    }   
}
$cntl = $i-$cnt;
$fmnt = $monthS.'-'.$yearS;
$lmnt = $monthL.'-'.$yearL;
@endphp

@extends('home.partial.layout')
@section('content')


<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
<style>
    /* .fixed-td{
        position: sticky;
        left:auto;
    }
    .fixed-th{
        position: sticky;
        top:auto;
    } */
    
</style>
<main id="main" class="main">
        <div class="pagetitle">
            <div class="row align-items-center">
                <div class="col">
                    <div class="pagetitle">
                        <h1>Employee Timesheet Report</h1>
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Home</a></li>
                                <li class="breadcrumb-item active">Timesheet Reports</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="d-flex justify-content-end">                    
                    <a id="dlink"  style="display:none;"></a>
                    <button type="button" class="btn btn-danger" onclick="return report.tableToExcel('tbl_exporttable_to_xls', 'EXCELREPORT', 'Timesheet Report.xls');">
                        Download Excel
                    </button>                    
                </div>
            </div>
            
        </div>

        <form action="{{route('timesheet-report.post')}}" method="post">
        @csrf 
        <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                    <label>Date From</label>
                        <input type="date" name="date_from" value="{{isset($request->date_from)?$request->date_from:$dates[0]['date']}}" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                    <label>Date To</label>
                        <input type="date" name="date_to" value="{{isset($request->date_to)?$request->date_to:date('Y-m-d')}}" class="form-control" required>
                    </div>
                </div>               

                <div class="col-md-2" style="padding-top: 2rem;">                    
                    <button type="submit" class="btn btn-block btn-alpha">Search</button>                    
                </div>

            </div>
        </form>       

        <div class="row">
            <div class="col-md-12" style="margin-top: 20px;">
                <div class="table-responsive" style="max-height: 700px; overflow-y: auto;">
                    <table class="table table-bordered table-striped table-hover table-responsive custom-table" id="tbl_exporttable_to_xls" style="display: inline-table; padding: 5px;">
                    
                    <thead class="fixed-th"  style="position: sticky; top: 0;z-index:999; ">
                        <tr>
                            <th colspan="{{count($dates)+5}}" style="background-color:#fff;font-size:16px;text-align:center;">{{$thiscompany}}</th>
                        </tr>
                        <tr>
                            <th colspan="{{count($dates)+5}}" style="background-color:#fff;font-size:16px;text-align:center;">Time Sheet for the month of {{$fmnt}} AND {{$lmnt}}</th>
                        </tr>
                        <tr>
                            <th colspan="2" style="background-color:#fff;"></th>
                            <th colspan="{{count($dates)}}" style="background-color:#9cc2e5;text-align:center;">Days Worked</th>
                            <th colspan="3" style="background-color:#fff;"></th>
                        </tr>
                        <tr>
                            <th colspan="2" style="background-color:#fff;"></th>
                            <th colspan="{{$cnt}}" style="text-align:center;background: #c2e0ab;">{{$monthS}}</th>
                            <th colspan="{{$cntl}}" style="text-align:center;background: #c2e0ab;">{{$monthL}}</th>
                            <th colspan="3" style="background-color:#fff;"></th>
                        </tr>
                        <tr>
                            <th class="fixed-td" style="background: #c2e0ab;font-weight: bold;position:sticky;">Id</th>
                            <th class="fixed-td" style="background: #c2e0ab;font-weight: bold;position:sticky;left:0;">Employee</th>
                            @foreach ($dates as $date)
                                <th style="background: #c2e0ab;font-weight: bold;">{{$date['no']}}</th>
                            @endforeach
                            <th style="background: #c2e0ab;font-weight: bold;">Worked</th>
                            <th style="background: #c2e0ab;font-weight: bold;">Paid</th>
                            <th style="background: #c2e0ab;font-weight: bold;">Unpaid</th>
                        </tr>
                    </thead>
                    <tbody>                        
                        @foreach ($groupedEmployees as $department => $employees)
                        <tr>
                                <td class="fixed-td" style="font-weight: bold;background:#9bb28a;">{{ $department }}</td>
                                <td class="fixed-td" style="font-weight: bold;background:#9bb28a;"></td>
                        </tr>
                        @foreach ($employees as $record)
                        @php $w=0; $p=0; $up=0; @endphp
                            <tr>
                                <td class="fixed-td" style="font-weight: bold;background:#c2e0ab;">{{$record->employee_no}}</td>
                                <td class="fixed-td" style="font-weight: bold;position:sticky;left:0;background:#c2e0ab;z-index:1;">{{$record->emp_name}}</td>
                                @foreach($record->leavedata as $tsdata)
                                        @if(null!=$tsdata['leave'])
                                            <td class="fw-bold" style="font-weight: bold;z-index:-999;background-color:{{$tsdata['leave'][0]->leavetypes->bg_color}}">
                                                @if($tsdata['leave'][0]->paid_status==1)
                                                    @php  $u='U'; @endphp
                                                @else
                                                    @php $u=''; @endphp
                                                @endif
                                                {{$u.$tsdata['leave'][0]->leavetypes->code}}
                                            </td>
                                        @elseif('Fri'==$tsdata['name'] || 'Sat'==$tsdata['name']) 
                                            <td class="fw-bold" style="font-weight: bold;z-index:-111;background-color:#fef2cb;">H</td>
                                        @else 
                                        @php $w++; @endphp
                                            <td class="fw-bold" style="font-weight: bold;z-index:-111;background-color:#FFFFFF;">R</td> 
                                        @endif
                                @endforeach
                                <td style="font-weight: bold;z-index:-111;">{{$record->worked}}</td>
                                <td style="font-weight: bold;z-index:-111;">{{$record->paid}}</td>
                                <td style="font-weight: bold;z-index:-111;">{{$record->unpaid}}</td>
                            </tr>
                        @endforeach
                    @endforeach
                        <tr style="position: sticky; left: 0;">
                            <td colspan="{{count($dates)+5}}" style="font-weight: bold; ">
                                <div class="row sticky-div" style="position: sticky; left: 0;display: flex; flex-flow: nowrap; margin-top: 1rem;">
                                    <div style="width: 20%;position: sticky; left: 0px;">
                                        Prepared by: <br />{{$creators['prepared']->name.' '.$creators['prepared']->lname}}
                                    </div>
                                    <div style="width: 20%;position: sticky; left: 30%;">
                                        Reviewed by: <br />{{$creators['reviewed']->name.' '.$creators['reviewed']->lname}} 
                                    </div>
                                    <div style="width: 20%;position: sticky; left: 60%;">
                                        Approved by: <br />{{$creators['approved']->name.' '.$creators['approved']->lname}}
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
</main>
@endsection

<script src="{{ asset('js/export.js') }}"></script>

<script>

        /* function ExportToExcel(type, fn, dl) {
            var elt = document.getElementById('tbl_exporttable_to_xls');
            var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
            return dl ?
                XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }) :
                XLSX.writeFile(wb, fn || ('Employee_Timesheet.' + (type || 'xlsx')));
        } */

    </script>
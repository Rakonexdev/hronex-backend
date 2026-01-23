@extends('home.partial.layout')
@section('content')

<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
<style>
    table,th,td{
        border: 1px solid #D8D8D8;
    }
</style>
    @php    
    use Carbon\Carbon;
    
    @endphp
<main id="main" class="main">
        <div class="pagetitle">
            <div class="row align-items-center">

                <div class="col">
                    <div class="pagetitle">
                        <h1>Employees Presence Report</h1>
                        <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item active">Employees Presence Report</li>
                        </ol>
                        </nav>
                        
                    </div>
                </div>
            </div>

            @if(NULL!=$employees)
            <div class="row">
                <div class="d-flex justify-content-end">                    
                        <button type="button" class="btn btn-danger" onclick="ExportToExcel('xlsx')">
                            Download Excel
                        </button>                    
                </div>
            </div>
            @endif

            <form action="{{route('emp-presence-report.post')}}" method="post">
            @csrf 
            <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Date</label>
                            <input type="date" name="curdate" id="curdate" value="{{$curDate}}" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Time From</label>
                            <input type="time" name="timefrom" id="timefrom" value="{{$timeFrom}}" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Time To</label>
                            <input type="time" name="timeto" id="timeto" value="{{$timeTo}}" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-md-2" style="padding-top: 2rem;">                    
                        <button type="submit" class="btn btn-block btn-alpha">Search</button>                    
                    </div>

                </div>
            </form>
        </div>

    @if(NULL!=$employees)
    <div class="row">
        <div class="col-md-12" style="margin-top: 20px;">
            <div class="table-responsive" style="max-height: 600px; overflow-y: scroll;">
                <table class="table table-striped custom-table" style="display: inline-table; padding: 5px;" id="table_result">
                    <thead style="position: sticky;top:0;z-index:1;">
                    <tr style="background-color: #D8D8D8;">
                        <th colspan="5">
                            <h4 style="text-align:center;">Employees Presence Report</h4>
                        </th>
                    </tr>                    
                    <tr style="background-color: #D8D8D8;">
                        <th>SL. No.</th>
                        <th>Employee No.</th>
                        <th>Name</th>
                        <th>Timing</th>
                    </tr>
                    </thead>
                 
                    <tbody>
                       @foreach($employees as $emp)
                       <tr>
                       <td>{{$loop->iteration}}</td>
                        <td>{{$emp['employee_no']}}</td>
                        <td>{{$emp['employee_fullname']}}</td>
                        <td style="font-size:11px;">
                            @if(NULL!=$emp['timing'])
                                @foreach($emp['timing'] as $eahatt)
                                    {{$eahatt}}<br />
                                @endforeach
                            @endif
                        </td>
                       </tr>
                       @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
   @endif

</main>
@endsection

<script>

    function ExportToExcel(type, fn, dl) {
        var elt = document.getElementById('table_result');        
        var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });  
        return dl ?
            XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }) :
            XLSX.writeFile(wb, fn || ('Employees Presence Report.' + (type || 'xlsx')));
    }

</script>
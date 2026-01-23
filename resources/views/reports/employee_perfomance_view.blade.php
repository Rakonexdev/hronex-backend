
<div class="row">
    <div class="col-sm-12" style="margin-top: 30px;">
        <div class="card">
            <div class="card-body">
                <div class="tab-box">
                    <div class="row user-tabs">
                        <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                            <ul class="nav nav-tabs nav-tabs-solid">
                                <li class="nav-item"><a href="#appr_technical1" data-toggle="tab" class="nav-link active">Appraisal</a></li>
                                <li class="nav-item"><a href="#appr_organizational1" data-toggle="tab" class="nav-link">PPR</a></li> 
                                <li class="nav-item"><a href="#appr_organizational2" data-toggle="tab" class="nav-link">SCF</a></li> 
                                <li class="nav-item"><a href="#appr_organizational3" data-toggle="tab" class="nav-link">PIP</a></li> 
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-content">
                    <!--Tab1-->
                    <div id="appr_technical1" class="pro-overview tab-pane fade active show">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="bg-white">
                                    @if($appraisal->isNotEmpty())
                                        <table class="table table-striped custom-table datatable ">
                                            <thead>
                                                <tr>
                                                    <th colspan="2" style="margin-right: 10px;">Report date</th>
                                                    <th colspan="2"></th>
                                                    <th >
                                                        View
                                                    </th>
                                                </tr>
                                                @foreach($appraisal as $report)
                                                    <tr>
                                                        <th colspan="2" style="margin-right: 10px;">{{$report->evaluation_date}}</th>
                                                        <th colspan="2"></th>
                                                        <th >
                                                            <a href="{{ route('appraisal.report',$report->id) }}" class="btn btn-primary" >View</a>
                                                        </th>
                                                    </tr>
                                                @endforeach
                                            </thead>
                                        </table>
                                    @else
                                        <p>No data available for the selected employee.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                     <!--Tab2-->
                    <div id="appr_organizational1" class="pro-overview tab-pane fade  ">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="bg-white">
                                    @if($ppr->isNotEmpty())
                                        <table class="table table-striped custom-table datatable ">
                                            <thead>
                                                @foreach($ppr as $ppr_report)
                                                    <tr>
                                                        <th colspan="2" style="margin-right: 10px;">Report date</th>
                                                        <th colspan="2"></th>
                                                        <th >
                                                            View
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="2" style="margin-right: 10px;">{{$ppr_report->review_date}}</th>
                                                        <th colspan="2"></th>
                                                        <th  style="margin-left : 30px;">
                                                            <a href="{{ route('ppr_related.report',$ppr_report->id) }}" class="btn btn-primary">View</a>
                                                        </th>
                                                    </tr>
                                                @endforeach
                                            </thead>
                                        </table>
                                    @else
                                        <p>No data available for the selected employee.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                      <!--Tab3-->
                    <div id="appr_organizational2" class="pro-overview tab-pane fade  ">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="bg-white">
                                    @if($scf->isNotEmpty())
                                        <table class="table table-striped custom-table datatable ">
                                            <thead>
                                                @foreach($scf as $ppr_report)
                                                    <tr>
                                                        <th colspan="2" style="margin-right: 10px;">Report date</th>
                                                        <th colspan="2"></th>
                                                        <th >
                                                            View
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="2" style="margin-right: 10px;">{{$ppr_report->scf_date}}</th>
                                                        <th colspan="2"></th>
                                                        <th  style="margin-left : 30px;">
                                                            <a href="{{ route('scf_related.report',$ppr_report->id)}}" class="btn btn-primary">View</a>
                                                        </th>
                                                    </tr>
                                                @endforeach
                                            </thead>
                                        </table>
                                    @else
                                        <p>No data available for the selected employee.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                       <!--Tab4-->
                    <div id="appr_organizational3" class="pro-overview tab-pane fade  ">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="bg-white">
                                    @if($pip->isNotEmpty())
                                        <table class="table table-striped custom-table datatable ">
                                            <thead>
                                                @foreach($pip as $ppr_report)
                                                    <tr>
                                                        <th colspan="2" style="margin-right: 10px;">Report date</th>
                                                        <th colspan="2"></th>
                                                        <th >
                                                            View
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="2" style="margin-right: 10px;">{{$ppr_report->date}}</th>
                                                        <th colspan="2"></th>
                                                        <th  style="margin-left : 30px;">
                                                            <a href="{{route('pip_related.report',$ppr_report->id)}}" class="btn btn-primary">View</a>
                                                        </th>
                                                    </tr>
                                                @endforeach
                                            </thead>
                                        </table>
                                    @else
                                        <p>No data available for the selected employee.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
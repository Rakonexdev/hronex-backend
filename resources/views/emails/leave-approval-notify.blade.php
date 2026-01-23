<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{trans('messages.leave_decs_notif')}}</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <h4><!--The Principal--> {{$head}} the leave request</h4>

    <p><span>Employee :</span> <strong>{{ucfirst($employee)}}</strong></p>
    <p><span>Leave Type :</span> <strong>{{ucfirst($leave_type)}}</strong></p>
    <p><span>Date :</span> <strong>{{date('d/m/Y', strtotime($date_from)).' - '.date('d/m/Y', strtotime($date_to))}}</strong></p>
    @if(isset($comment))
        <p>Comment :</p><strong>{{$comment}}</strong>
    @endif

    <p>For more details: Just follow the link down below to visit the page:</p>
    <a href="{{url('leaveapproval')}}">
        Click here
    </a>
    
</body>
</html>

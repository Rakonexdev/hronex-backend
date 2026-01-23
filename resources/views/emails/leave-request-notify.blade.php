<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Request Notification</title>
</head>
<body>
    <h4>Leave Request is awaiting your decision</h4>

    <p><span>Employee :</span> <strong>{{ucfirst($employee)}}</strong></p>
    <p><span>Leave Type :</span> <strong>{{ucfirst($leave_type)}}</strong></p>
    <p><span>Date :</span> <strong>{{date('d/m/Y', strtotime($date_from)).' - '.date('d/m/Y', strtotime($date_to))}}</strong></p>

    <p>Just follow the link down below to visit the page:</p>
    <a href="{{url('leaveapproval')}}">
        Click here
    </a>
    
</body>
</html>

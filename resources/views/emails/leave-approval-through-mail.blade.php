<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Approve/Reject Decision Making Email</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <h4>Leave Request is awaiting your decision</h4>

    <p><span>Employee :</span> <strong>{{ucfirst($employee)}}</strong></p>
    <p><span>Leave Type :</span> <strong>{{ucfirst($leave_type)}}</strong></p>
    <p><span>Date :</span> <strong>{{date('d/m/Y', strtotime($date_from)).' - '.date('d/m/Y', strtotime($date_to))}}</strong></p>

    <p>Click on the buttons below to make a decision:</p>

    <a href="{{ url('leave_decision_mail', ['token' => $tokenA ]) }}" style="text-decoration: none;">
        <button style="background-color: #489348;border: #489348;padding: 10px 20px;color: #FFF;border-radius: 4px;cursor: pointer;font-weight: 800;">Approve</button>
    </a>

    &nbsp;&nbsp;

    <a href="{{ url('leave_decision_mail', ['token' => $tokenR ]) }}" style="text-decoration: none;">
        <button style="background-color: #e83b3b;border: #e83b3b;padding: 10px 20px;color: #FFF;border-radius: 4px;cursor: pointer;font-weight: 800;">Reject</button>
    </a>

    <p style="font-weight: 800;">OR</p>

    <p>Just follow the link down below to visit the page and make the decision:</p>
    <a href="{{url('leaveapproval')}}">
        Click here
    </a>

</body>
</html>

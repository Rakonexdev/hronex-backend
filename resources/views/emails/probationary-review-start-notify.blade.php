<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Probationary Review Start Notification</title>
</head>
<body>
    <h4>{{trans('messages.warn_probat_pending')}}</h4>

    <p><span>Employee :</span> <strong>{{ucfirst($employee)}}</strong></p>
    <p><span>Joining Date :</span> <strong>{{date('d/m/Y', strtotime($joiningdate))}}</strong></p>
    
</body>
</html>

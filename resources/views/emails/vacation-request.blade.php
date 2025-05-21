<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #4F46E5;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f9fafb;
            padding: 20px;
            border: 1px solid #e5e7eb;
            border-radius: 0 0 5px 5px;
        }
        .details {
            background-color: white;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4F46E5;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>New Leave Request</h2>
        </div>
        <div class="content">
            <p>Hello,</p>

            <p>A new leave request has been submitted by <strong>{{ $employee->name }}</strong>.</p>

            <div class="details">
                <h3>Request Details:</h3>
                <p><strong>Start Date:</strong> {{ \Carbon\Carbon::parse($leaveRequest->start_date)->format('F j, Y') }}</p>
                <p><strong>End Date:</strong> {{ \Carbon\Carbon::parse($leaveRequest->end_date)->format('F j, Y') }}</p>
                <p><strong>Duration:</strong> {{ \Carbon\Carbon::parse($leaveRequest->start_date)->diffInDays($leaveRequest->end_date) + 1 }} days</p>
                @if($leaveRequest->note)
                    <p><strong>Reason:</strong> {{ $leaveRequest->note }}</p>
                @endif
            </div>

            <p>Please review this request and take appropriate action.</p>

            <a href="{{ config('app.url') }}/leave-requests" class="button">View Request</a>

            <p>Best regards,<br>HR System</p>
        </div>
    </div>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Appointment Confirmation</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            color: #333;
            line-height: 1.6;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #2c3e50;
            color: #ffffff;
            text-align: center;
            padding: 15px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .header h2 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 20px;
        }
        .details {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-top: 15px;
        }
        .details p {
            margin: 8px 0;
        }
        .details strong {
            display: inline-block;
            width: 150px;
            color: #2c3e50;
        }
        .details ul {
            list-style-type: disc;
            padding-left: 20px;
            margin: 10px 0;
        }
        .footer {
            text-align: center;
            padding: 15px;
            color: #7f8c8d;
            font-size: 14px;
        }
        .button {
            display: inline-block;
            padding: 12px 25px;
            background-color: #3498db;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 20px;
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Appointment Confirmation</h2>
        </div>
        <div class="content">
            <p>Dear {{ $appointment->pet->petParent->name }},</p>

            <p>Your appointment has been successfully booked. Below are the details:</p>

            <div class="details">
                <p><strong>Appointment Code:</strong> {{ $appointment->appointment_code }}</p>
                <p><strong>Date:</strong> {{ $appointment->appointment_date }}</p>
                <p><strong>Time:</strong> {{ $appointment->appointment_time }}</p>
                <p><strong>Lab:</strong> {{ $appointment->branch->name }}</p>
                <p><strong>Pet:</strong> {{ $appointment->pet->name }}</p>

                <p><strong>Tests:</strong></p>
                <ul>
                    @foreach($appointment->tests as $test)
                        <li>{{ $test->name }}</li>
                    @endforeach
                </ul>

                <p><strong>Total:</strong> {{ $appointment->total }}</p>
                <p><strong>Payment Status:</strong> {{ ucfirst($appointment->payment_status) }}</p>
            </div>

            <p>Thank you for choosing our services!</p>
            <p class="footer">Best regards,<br>{{ config('app.name') }}</p>

            <a href="{{ url('/') }}" class="button">Visit Our Website</a>
        </div>
    </div>
</body>
</html>
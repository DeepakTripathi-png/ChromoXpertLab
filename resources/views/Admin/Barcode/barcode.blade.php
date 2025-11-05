<!DOCTYPE html>
<html>
<head>
    <title>Barcode</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <style>
        .barcode-container { text-align: center; margin-bottom: 20px; }
        hr { border-top: 1px solid #ccc; margin: 20px 0; }
        @media print {
            .btn { display: none; }
            .barcode-container { margin: 0; }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card mt-5">
        <div class="card-body">
            <h3>Appointment: {{ $appointment_code }} ({{ $sampleCount }} Samples)</h3>
            <div class="barcode-container">{!! $barcode !!}</div>
            <button onclick="window.print()" class="btn btn-primary">Print Barcode</button>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
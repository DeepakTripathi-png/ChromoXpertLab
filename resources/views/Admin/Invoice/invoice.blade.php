<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>ChromoXpert Diagnostics - Invoice</title>
    <style>
        @page {
            size: A5;
            margin: 0.2cm;
        }
        
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fff;
            color: #000;
            font-size: 11px;
            line-height: 1.2;
        }
        
        .container {
            width: 100%;
            max-width: 14.8cm;
            margin: 0 auto;
            padding: 4px;
            box-sizing: border-box;
        }
        
        .header {
            text-align: center;
            margin-bottom: 5px;
            padding-bottom: 3px;
            border-bottom: 1px solid #000;
        }
        
        .header h2 {
            font-size: 16px;
            margin: 2px 0;
        }
        
        .header p {
            font-size: 9px;
            margin: 1px 0;
        }
        
        .invoice-info table {
            width: 100%;
            border-collapse: collapse;
            border: none;
            margin-bottom: 8px;
        }
        
        .invoice-info td {
            border: none;
            padding: 0 5px 0 0;
            vertical-align: top;
        }
        
        .info-group {
            width: 100%;
        }
        
        .info-item {
            margin: 2px 0;
            font-size: 9px;
            line-height: 1.2;
            padding: 1px 0;
        }
        
        table.tests {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
            margin-bottom: 8px;
        }
        
        .tests th, .tests td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }
        
        .tests th {
            font-weight: bold;
            background-color: #f0f0f0;
        }
        
        .tests td.price {
            text-align: right;
        }
        
        .bottom-section {
            margin-top: 10px;
            border-top: 1px solid #000;
            padding-top: 5px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        
        .amounts-and-print {
            flex: 1;
            padding-right: 10px;
        }
        
        .amount-summary {
            font-size: 10px;
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        
        .amount-item {
            margin: 0;
            flex: 1;
            text-align: left;
            padding: 0 5px;
        }
        
        .amount-item span {
            margin-left: 5px;
        }
        
        .print-date {
            font-size: 9px;
        }
        
        .signature {
            text-align: right;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }
        
        .signature img {
            height: 60px; /* Reduced from 80px to make it more compact */
            margin-right: 0;
            margin-bottom: 5px;
        }
        
        .signature p {
            margin: 2px 0;
        }
        
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            
            .container {
                border: none;
                padding: 0;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="{{ public_path('package_assets/images/logo.png') }}" alt="ChromoXpert Diagnostics Logo" style="height: 50px; margin-bottom: 5px;">
            <h2>ChromoXpert Diagnostics</h2>
            <p>Advanced Diagnostic Testing for Pets</p>
            <p>Navi Mumbai, India | Helpline: 7506193580</p>
            <p>Email: info@chromoxpert.com | Web: www.chromoxpert.com</p>
        </div>

        <div class="invoice-info">
            <table>
                <tr>
                    <td style="width: 33%;">
                        <div class="info-group">
                            <div class="info-item"><strong>Invoice No:</strong> {{ $appointmentDetails->invoice_no ?? 'APT' . str_pad($appointmentDetails->id, 3, '0', STR_PAD_LEFT) }}</div>
                            <div class="info-item"><strong>Pet ID:</strong> {{ $appointmentDetails->pet->pet_code ?? 'N/A' }}</div>
                            <div class="info-item"><strong>Lab ID:</strong> {{ $appointmentDetails->branch->lab_code ?? 'N/A' }}</div>
                        </div>
                    </td>
                    <td style="width: 33%;">
                        <div class="info-group">
                            <div class="info-item"><strong>Pet Name:</strong> {{ $appointmentDetails->pet->name ?? 'N/A' }}</div>
                            <div class="info-item"><strong>Owner Name:</strong> {{ $appointmentDetails->pet->petParent->name ?? 'N/A' }}</div>
                            <div class="info-item"><strong>Contact:</strong> {{ $appointmentDetails->pet->petParent->mobile ?? 'N/A' }}</div>
                        </div>
                    </td>
                    <td style="width: 33%;">
                        <div class="info-group">
                            <div class="info-item"><strong>Species:</strong> {{ $appointmentDetails->pet->species ?? 'N/A' }}</div>
                            <div class="info-item"><strong>Age:</strong> {{ $appointmentDetails->pet->age ?? 'N/A' }} {{ $appointmentDetails->pet->age_unit ?? 'days' }}</div>
                            <div class="info-item"><strong>Referred By:</strong> {{ $appointmentDetails->refereeDoctor->doctor_name ?? 'N/A' }}</div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <table class="tests">
            <thead>
                <tr>
                    <th>Sr.No</th>
                    <th>Department</th>
                    <th>Test Name</th>
                    <th>Price (Rs)</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; $srNo = 1; @endphp
                @foreach($appointmentDetails->tests ?? [] as $test)
                    <tr>
                        <td>{{ $srNo++ }}</td>
                        <td>{{ $test->department->department_name ?? 'N/A' }}</td>
                        <td>{{ $test->name ?? 'N/A' }}</td>
                        <td class="price">{{ number_format($test->base_price ?? 0, 2) }}</td>
                    </tr>
                    @php $total += $test->base_price ?? 0; @endphp
                @endforeach

                @if(empty($appointmentDetails->tests))
                    <tr>
                        <td colspan="4">No tests found</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <div class="bottom-section">
            <div class="amounts-and-print">
                <div class="amount-summary">
                    <div class="amount-item">
                    @php $total = $appointmentDetails->total @endphp
                        <strong>Payable Amount with GST (Rs):</strong> 
                        <span>{{ number_format($total, 2) }}</span>
                    </div>
                    <div class="amount-item">
                        <strong>Amount Paid (Rs):</strong> 
                        <span>{{ number_format($appointmentDetails->paid_amount ?? $total, 2) }}</span>
                    </div>
                    <div class="amount-item">
                        <strong>Due Amount (Rs):</strong> 
                        <span>{{ number_format($total - ($appointmentDetails->paid_amount?? $total), 2) }}</span>
                    </div>
                </div>
                <div class="print-date">
                    <p>Print Date: {{ now()->format('d-M-Y h:i A') }}</p>
                </div>
            </div>
            <div class="signature">
                <img src="{{ public_path('package_assets/images/stamp.png') }}" alt="Signature"/><br/>
                <p>__________________________</p>
                <p>Authorized Signatory</p>
            </div>
        </div>
    </div>
</body>
</html>
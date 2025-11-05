<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>ChromoXpert - Report</title>
    <style>
        /* Page setup for A4 PDF printing */
        @page { size: A4; margin: 18mm 14mm; }
        body { font-family: 'DejaVu Sans', Arial, Helvetica, sans-serif; font-size: 10px; color: #000; margin: 0; line-height: 1.1; padding-top: 70px; padding-bottom: 80px; }
        .container { width: 100%; page-break-inside: avoid; }
        .new-page { page-break-before: always; }

        /* Header layout (three columns: left address, center logo, right contact) */
        .header { 
            position: fixed; 
            top: 0; 
            left: 0; 
            right: 0; 
            width:100%; 
            display: table; 
            table-layout: fixed; 
            z-index: 1000;
        }
        .header .col { display: table-cell; vertical-align: middle; }
        .header .left { width: 30%; text-align: left; }
        .header .center { width: 40%; text-align: center; }
        .header .right { width: 30%; text-align: right; }

        .small { font-size: 9px; line-height: 1.4; }
        .muted { color: #333; }

        /* Improved meta section with proper three-column layout */
        .meta { 
            width:100%; 
            display: table; 
            table-layout: fixed; 
            margin-top: 6px; 
            margin-bottom: 8px; 
            /* border: 1px solid #ddd; 
            border-radius: 4px;  */
            padding: 0; 
            /* background-color: #f9f9f9;  */
        }
        .meta .cell { 
            display: table-cell; 
            vertical-align: top; 
            padding: 0;
            width: 33.33%; /* Equal width for all three columns */
        }
        .meta .left { text-align: left; }
        .meta .center { text-align: left; }
        .meta .right { text-align: left; }
        .meta .cell > div {
            display: table;
            width: 100%;
            table-layout: fixed;
            margin-bottom: 1px;
        }

        .label1 { 
            display: table-cell;
            width: 50%;
            font-weight: bold;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            padding-right: 1px;
        }

        .value1 { 
            font-weight: normal; 
            display: table-cell;
            width: 50%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .label2 { 
            display: table-cell;
            width: 50%;
            font-weight: bold;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            padding-right: 1px;
        }

        .value2 { 
            font-weight: normal; 
            display: table-cell;
            width: 50%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .label3 { 
            display: table-cell;
            width: 55%;
            font-weight: bold;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            padding-right: 0px;
        }
        .value3 { 
            font-weight: normal; 
            display: table-cell;
            width: 45%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        hr.thin { border: none; border-top: 1px solid #111; margin: 6px 0 8px 0; }

        .section-title { text-align:center; font-weight:700; text-decoration: underline; margin: 6px 0 8px 0; }

        /* Main table styles */
        table.report { width: 100%; border-collapse: collapse; }
        table.report thead th { text-align: left; padding: 4px; font-weight:700; border-bottom: 1px solid #000; }
        table.report tbody td { padding: 2px; vertical-align: top; }
        table.report .col-test { width: 25%; }
        table.report .col-value { width: 25%; text-align: right; }
        table.report .col-ref { width: 25%; text-align: center; }
        table.report .col-unit { width: 25%; text-align: center; }

        .nowrap { white-space: nowrap; }

        /* small helper blocks */
        .note { font-size: 9px; margin-top: 16px; }

        /* signature area */
        .signatures { width:100%; display: table; table-layout: fixed; margin-top: 20px; }
        .signatures .sig { display: table-cell; vertical-align: top; text-align: center; padding-top: 30px; width: 50%; }
        .sig .name { font-weight:700; }
        .sig .qual { font-size: 9px; margin-top:3px; }

        /* ensure tables don't overflow when PDF engine renders */
        img { max-width:100%; height: auto; }
        .small-muted { font-size: 8px; color:#444; }

        .tagline { font-size: 7px; color: #666; text-align: center; margin-top: 2px; letter-spacing: 0.5px; }

        /* Status indicators */
        .status-normal { color: green; }
        .status-abnormal { color: red; }

        /* Print-friendly adjustments */
        @media print {
            body { -webkit-print-color-adjust: exact; }
            .meta .cell > div {
                white-space: nowrap !important;
                overflow: hidden !important;
            }
            .label1, .label2, .label3, .value1, .value2, .value3 {
                white-space: nowrap !important;
            }
        }

        /* Footer layout - FIXED */
        footer { 
            width:100%; 
            display: table; 
            table-layout: fixed; 
            position: fixed; 
            bottom: 0;
            left: 0;
            right: 0;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        footer .col { 
            display: table-cell; 
            vertical-align: top; 
        }
        footer .left { 
            width: 40%; 
            text-align: left; 
            padding-left: 5px;
        }
        footer .center { 
            width: 20%; 
            text-align: center; 
            font-size: 18px; 
            font-weight: bold; 
            color: #504e4e; 
            vertical-align: middle;
            padding: 8px;
        }
        footer .right { 
            width: 40%; 
            text-align: right; 
            padding-right: 5px; 
        }
        footer .qr { 
            height: 50px; 
            margin: 2px 0; 
            opacity: 0.8; 
            display: block; 
        }
        footer .animals { 
            height: 60px; 
            opacity: 0.7; 
            filter: hue-rotate(270deg) saturate(1.2);
            display: block;
            margin-top: 5px;
        }
        
        /* Fixed address and contact layout */
        .footer-contact {
            display: table;
            width: 100%;
        }
        .footer-address, 
        .footer-contact-info {
            display: table-cell;
            vertical-align: top;
            width: 50%;
            font-size: 7px;
            line-height: 1.2;
            color: #555;
            text-align: left;
            padding: 0 3px;
        }
        .footer-address {
            text-align: left;
            padding-right: 8px;
        }
        .footer-contact-info {
            text-align: left;
        }
        
        /* Ensure text doesn't break incorrectly */
        .footer-text {
            word-wrap: break-word;
            white-space: normal;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="col left small muted">
            <div>234, Silver Springs,</div>
            <div>Taloja MIDC, Plot 6, Taloja,</div>
            <div>Navi Mumbai, 410208.</div>
        </div>

        <div class="col center">
            <img src="{{ public_path('package_assets/images/logo.png') }}" alt="ChromoXpert Diagnostics Logo" style="height: 50px; margin-bottom: 2px;">
            <div class="tagline">FOR IMPROVED HEALTH & GENETICS</div>
        </div>

        <div class="col right small muted">
            <div>M : 7506193580</div>
            <div>E : info@chromoxpert.com</div>
            <div>W : www.chromoxpert.com</div>
        </div>
    </div>

@foreach($reports as $index => $reportData)
    @if($index > 0)
        <div class="new-page"></div>
    @endif
    <div class="container">

        <div class="meta">
            <div class="cell left small">
                <div><span class="label1">Pet Name :</span> <span class="value1">{{ $reportData['appointment']['pet']['name'] ?? '' }}</span></div>
                <div><span class="label1">Pet Parents/Care Of :</span> <span class="value1">{{ $reportData['appointment']['pet']['petParent']['name'] ?? '' }}</span></div>
                <div><span class="label1">Species :</span> <span class="value1">{{ $reportData['appointment']['pet']['species'] ?? '' }}</span></div>
                <div><span class="label1">Age :</span> <span class="value1">{{ $reportData['appointment']['pet']['age'] ?? '' }}</span></div>
            </div>
            <div class="cell center small">
                <div><span class="label2">Reg No :</span> <span class="value2">{{ $reportData['appointment']['appointment_code'] ?? '' }}</span></div>
                <div><span class="label2">Sample Id :</span> <span class="value2">{{ $reportData['testResult']['test_result_code'] ?? '' }}</span></div>
                <div><span class="label2">Breed :</span> <span class="value2">{{ $reportData['appointment']['pet']['breed'] ?? '' }}</span></div>
                <div><span class="label2">Sex :</span> <span class="value2">{{ $reportData['appointment']['pet']['gender'] ?? '' }}</span></div>
            </div>   
            <div class="cell right small">
                <div><span class="label3">Sample Collection Date :</span> <span class="value3">10 Sep 25, 10:50 AM</span></div>
                <div><span class="label3">Sample Reg. Date :</span> <span class="value3">10 Sep 25, 10:50 AM</span></div>
                <div><span class="label3">Sample Reporting Date :</span> <span class="value3">10 Sep 25, 10:50 AM</span></div>
                <div><span class="label3">Ref. By :</span> <span class="value3">{{ $reportData['appointment']['refereeDoctor']['doctor_name'] ?? '' }}</span></div>
            </div>
        </div>

        <hr class="thin">
        <div class="section-title">{{ $reportData['test']['name'] ?? '' }} ({{ ucfirst(strtolower($reportData['appointment']['pet']['species'] ?? '')) }})</div>

        <table class="report">
            <thead>
                <tr>
                    <th class="col-test">Test Description</th>
                    <th class="col-value">Value(s)</th>
                    <th class="col-ref">Reference Range</th>
                    <th class="col-unit">Unit(s)</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $components = collect($reportData['testResult']['components'] ?? []);
                    $parameters = collect($reportData['test']['parameters'] ?? [])->sortBy('sort_order');
                @endphp
                @foreach($parameters as $parameter)
                    @if($parameter->row_type == 'title')
                        <tr>
                            <td colspan="4" style="padding-top:4px;"><strong>{{ $parameter->title ?? '' }}</strong></td>
                        </tr>
                    @else
                        @php
                            $component = $components->firstWhere('component_id', $parameter->id);
                            $result = $component->result ?? '';
                            $statusClass = $component->result_status ?? 'normal';
                            $refRange = $parameter->reference_range ?? '-';
                            $unit = $parameter->unit ?? '';
                            $testName = $parameter->name ?? $parameter->title ?? '';
                        @endphp
                        <tr>
                            <td>{{ $testName }}</td>
                            <td class="nowrap" style="text-align:right;">{{ $result }}</td>
                            <td class="nowrap" style="text-align:center;">{{ $refRange }}</td>
                            <td class="nowrap" style="text-align:center;">{{ $unit }}</td>
                        </tr>
                    @endif
                @endforeach
                @if($parameters->isEmpty())
                    <tr>
                        <td colspan="4">No parameters available.</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <div class="note small-muted">Note: This report is computer generated and should be correlated clinically. For inquiries contact info@chromoxpert.com.</div>

        <div class="signatures">
            <div class="sig">
                <div class="name">Dr. Nikhil Sonone</div>
                <div class="qual">M.V.Sc Pathology</div>
                <div class="small-muted">Reg No. 10662</div>
            </div>
            <div class="sig">
                <div class="name">Dr. Rahul Deshmukh</div>
                <div class="qual">M.V.Sc Animal Genetics, M.Sc (Sweden)</div>
                <div class="small-muted">MSVC Reg no. 6873</div>
            </div>
        </div>
    </div>
@endforeach

    <!-- FIXED FOOTER -->
    <footer>
        <div class="col left">
            <img src="{{ public_path('package_assets/images/barcode.png') }}" alt="QR Code" class="qr">
            <img src="{{ public_path('package_assets/images/animal.png') }}" alt="Animal Silhouettes" class="animals">
        </div>
        <div class="col center">
         
        </div>
        <div class="col right">
            <div class="footer-contact">
                <div class="footer-address footer-text">
                    234, Silver Springs,<br>
                    Taloja MIDC, Plot 6, Taloja,<br>
                    Navi Mumbai, 410208.
                </div>
                <div class="footer-contact-info footer-text">
                    M: 7506193580<br>
                    E: info@chromoxpert.com<br>
                    W: www.chromoxpert.com
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
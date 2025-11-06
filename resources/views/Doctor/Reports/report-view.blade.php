@extends('Doctor.Layouts.layout')

@section('meta_title', 'View Test Report | ChromoXpert')

@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid mt-3">

            {{-- Hero Header --}}
            <div class="p-4 rounded-4 position-relative overflow-hidden shadow-lg"
                 style="background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%); color: #fff;">
                <h2 class="fw-bold mb-1">Tests & Components</h2>
                <p class="mb-0">Manage test results and component details</p>
                <a  href="{{ url()->previous() }}"  
                       class="btn btn-light btn-lg mt-3 fw-semibold rounded-pill shadow-sm"
                       style="background: #f6b51d; color: #1f2937; border: none;">
                        <i class="mdi mdi-arrow-left me-2"></i> Back
                </a>
                <div class="position-absolute top-0 end-0 opacity-25" style="font-size: 120px; color: #ac7fb6;">
                    <i class="mdi mdi-flask"></i>
                </div>
            </div>

            
             {{-- Controls --}}
            <div class="mt-4 mb-3">
                <div class="mb-3">
                    <span class="text-secondary fw-semibold">Select tests and cultures to be printed in the report</span>
                </div>

                {{-- <div class="d-flex flex-wrap gap-2">
                  
                    @if($report_status=="rejected") 
                    <button class="btn btn-light btn-lg fw-semibold rounded-pill shadow-sm approve-report"
                            style="background: #28a745; color: #fff; border: none;"
                            onclick="approveReport('{{ $id }}')">
                        <i class="fas fa-check-circle me-2"></i> Approve
                    </button>
                    <button class="btn btn-light btn-lg fw-semibold rounded-pill shadow-sm reject-report"
                            style="background: #dc3545; color: #fff; border: none;"
                            onclick="openRejectionModal('{{ $id }}')">
                        <i class="fas fa-times-circle me-2"></i> Reject
                    </button>
                    @else
                      <button class="btn btn-approve" onclick="reApproveReport('{{ $report->test_result_code }}')">Re-Approve</button>
                    @endif
                    
                    <button class="btn btn-light btn-lg fw-semibold rounded-pill shadow-sm"
                            style="background: #28a745; color: #fff; border: none;"
                            onclick="selectAllTests(true)">
                        <i class="fas fa-check-double me-2"></i> Select all
                    </button>
                    <button class="btn btn-light btn-lg fw-semibold rounded-pill shadow-sm"
                            style="background: #dc3545; color: #fff; border: none;"
                            onclick="selectAllTests(false)">
                        <i class="fas fa-times me-2"></i> Deselect all
                    </button>
                    <button class="btn btn-light btn-lg fw-semibold rounded-pill shadow-sm print-report"
                            style="background: #f6b51d; color: #1f2937; border: none;">
                        <i class="fas fa-print me-2"></i> Print
                    </button>
                    <button id="animalInfo" class="btn btn-light btn-lg fw-semibold rounded-pill shadow-sm ms-2"
                            style="background: #cc235e; color: #fff; border: none;"
                            data-bs-toggle="modal" data-bs-target="#animalInfoModal">
                        <i class="mdi mdi-paw me-2"></i> Animal info
                    </button>
                    <a href="{{url('doctor/generate-reports/'.$id)}}" class="btn btn-light btn-lg fw-semibold rounded-pill shadow-sm edit-report"
                    style="background: #007bff; color: #fff; border: none; text-decoration: none;">
                        <i class="fas fa-edit me-2"></i> Edit
                    </a>
                </div> --}}


            <div class="d-flex flex-wrap gap-2">

                    @if($report_status == "pending") 
                        {{-- Pending Reports --}}
                        <button class="btn btn-light btn-lg fw-semibold rounded-pill shadow-sm approve-report"
                                style="background: #28a745; color: #fff; border: none;"
                                onclick="approveReport('{{ $id }}')">
                            <i class="fas fa-check-circle me-2"></i> Approve
                        </button>

                        <button class="btn btn-light btn-lg fw-semibold rounded-pill shadow-sm reject-report"
                                style="background: #dc3545; color: #fff; border: none;"
                                onclick="openRejectionModal('{{ $id }}')">
                            <i class="fas fa-times-circle me-2"></i> Reject
                        </button>

                    @elseif($report_status == "approved")
                        {{-- Approved Reports --}}
                        @if(empty($signed_by_id))
                            <button class="btn btn-light btn-lg fw-semibold rounded-pill shadow-sm"
                                    style="background: #6f42c1; color: #fff; border: none;"
                                    onclick="signReport('{{ $id }}')">
                                <i class="fas fa-pen-nib me-2"></i> Sign
                            </button>
                        @else
                            
                        @endif

                    @elseif($report_status == "rejected")
                        {{-- Rejected Reports --}}
                        <button class="btn btn-approve btn-lg fw-semibold rounded-pill shadow-sm"
                                style="background: #17a2b8; color: #fff; border: none;"
                                onclick="reApproveReport('{{ $id }}')">
                            <i class="fas fa-redo me-2"></i> Re-Approve
                        </button>
                    @endif

                    {{-- Common Buttons --}}
                    <button class="btn btn-light btn-lg fw-semibold rounded-pill shadow-sm"
                            style="background: #28a745; color: #fff; border: none;"
                            onclick="selectAllTests(true)">
                        <i class="fas fa-check-double me-2"></i> Select all
                    </button>

                    <button class="btn btn-light btn-lg fw-semibold rounded-pill shadow-sm"
                            style="background: #dc3545; color: #fff; border: none;"
                            onclick="selectAllTests(false)">
                        <i class="fas fa-times me-2"></i> Deselect all
                    </button>

                    <button class="btn btn-light btn-lg fw-semibold rounded-pill shadow-sm print-report"
                            style="background: #f6b51d; color: #1f2937; border: none;">
                        <i class="fas fa-print me-2"></i> Print
                    </button>

                    <button id="animalInfo" class="btn btn-light btn-lg fw-semibold rounded-pill shadow-sm ms-2"
                            style="background: #cc235e; color: #fff; border: none;"
                            data-bs-toggle="modal" data-bs-target="#animalInfoModal">
                        <i class="mdi mdi-paw me-2"></i> Animal info
                    </button>
                    @if($report_status != "approved" && $report_status != "completed")
                        <a href="{{ url('doctor/generate-reports/'.$id) }}" 
                        class="btn btn-light btn-lg fw-semibold rounded-pill shadow-sm edit-report"
                        style="background: #007bff; color: #fff; border: none; text-decoration: none;">
                            <i class="fas fa-edit me-2"></i> Edit
                        </a>
                    @endif
                </div>


                
            </div>

            {{-- Tests --}}
            <div class="mb-3 px-3 py-2 rounded-3"
                 style="background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%); color: #fff; font-weight: 600;">
                Tests
            </div>

            <div id="testContainer">
                <!-- Test 1 -->
                @if(!empty($tests))
                    @foreach($tests as $index => $test)
                        @php
                            $testResult = $report->where('test_id', $test->id)->first();
                        @endphp
                        <div class="test-item" id="test{{ $test->id }}" data-test-result-id="{{ $testResult ? $testResult->id : '' }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <label>
                                    <input type="checkbox" class="test-checkbox">
                                    {{ $test->name ?? 'Test Name' }}
                                </label>
                                <div class="controls">
                                    <button class="toggle-btn" onclick="toggleDrawer(this)">+</button>
                                    <button class="close-btn" onclick="removeTest('test{{ $test->id }}')">×</button>
                                </div>
                            </div>

                            <div class="test-content">
                                <div class="test-title">{{ $test->name ?? 'Complete Blood Count' }}</div>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Test</th>
                                            <th>Result</th>
                                            <th>Unit</th>
                                            <th>Normal Range</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($test->parameters as $parameter)
                                            @if($parameter->row_type === 'title')
                                                <tr>
                                                    <td colspan="5" style="text-align: left; font-weight: bold;">
                                                        {{ $parameter->title ?? $parameter->name ?? 'Parameter Title' }}
                                                    </td>
                                                </tr>
                                            @elseif($parameter->row_type === 'component')
                                                @php
                                                    $component = $testResult ? $testResult->components->where('component_id', $parameter->id)->first() : null;
                                                @endphp
                                                <tr>
                                                    <td>{{ $parameter->name ?? 'Parameter Name' }}</td>
                                                    <td>{{ $component ? $component->result : 'N/A' }}</td>
                                                    <td>{{ $parameter->unit ?? 'Unit' }}</td>
                                                    <td>{{ $parameter->reference_range ?? $parameter->normal_range ?? 'Normal Range' }}</td>
                                                    <td>{{ $component ? $component->result_status : 'N/A' }}</td>
                                                </tr>
                                            @endif
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted">
                                                    No parameters found
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="comment">Comment: {{ $testResult ? $testResult->comment : 'No comment available' }}</div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Animal Info Modal -->
<div class="modal fade" id="animalInfoModal" tabindex="-1" aria-labelledby="animalInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4" style="background: rgba(255,255,255,0.85); backdrop-filter: blur(14px);">
            <div class="modal-header" style="background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%); color: #fff;">
                <h5 class="modal-title" id="animalInfoModalLabel">Animal Info</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="mb-2"><strong>Name:</strong> {{ $appointment->pet->name ?? '' }}</p>
                <p class="mb-2"><strong>Gender:</strong> {{ $appointment->pet->gender ?? '' }}</p>
                <p class="mb-2"><strong>Date of birth:</strong> {{ $appointment->pet->dob ?? '' }}</p>
                <p class="mb-2"><strong>Age:</strong> {{ $appointment->pet->age ?? '' }}</p>
                <p class="mb-2"><strong>Owner name:</strong> {{ $appointment->pet->petparent->name ?? '' }}</p>
                <p class="mb-2"><strong>Phone:</strong> {{ $appointment->pet->petparent->mobile ?? '' }}</p>
                <p class="mb-2"><strong>Email:</strong> {{ $appointment->pet->petparent->email ?? '' }}</p>
                <p class="mb-2"><strong>Address:</strong> {{ $appointment->pet->petparent->address ?? '' }}</p>
            </div>
            <div class="modal-footer" style="background: linear-gradient(135deg, #ac7fb6 0%, #f6b51d 100%);">
                <button type="button" class="btn btn-light rounded-pill shadow-sm" style="background: #fff; color: #6267ae; border: none;" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Rejection Modal -->
<div class="modal" id="rejectionModal">
    <div class="modal-content">
        <span class="modal-close" onclick="closeRejectionModal()">&times;</span>
        <h3>Reject Report</h3>
        <p>Please provide a reason for rejection:</p>
        <form id="rejectionForm" class="rejection-form">
            <input type="hidden" id="rejectReportId" name="report_id">
            <label for="rejectionReason">Rejection Reason:</label>
            <textarea id="rejectionReason" name="reason" placeholder="Enter the reason for rejecting this report..." required></textarea>
            <div class="action-row">
                <button type="button" class="btn btn-light fw-semibold rounded-pill shadow-sm" onclick="closeRejectionModal()" style="background: #6c757d; color: #fff; border: none;">Cancel</button>
                <button type="submit" class="btn btn-light fw-semibold rounded-pill shadow-sm" style="background: #dc3545; color: #fff; border: none;">Submit Rejection</button>
            </div>
        </form>
    </div>
</div>

{{-- Custom Styles --}}
<style>
    /* Test Item Card */
    .test-item {
        border: 2px solid #ac7fb6;
        margin-bottom: 15px;
        padding: 10px 15px;
        border-radius: 1rem;
        position: relative;
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(14px);
        box-shadow: 0 4px 6px rgb(0 0 0 / 0.1);
        transition: all 0.3s ease;
    }
    
    .test-item:hover {
        box-shadow: 0 6px 12px rgb(0 0 0 / 0.15);
    }
    
    .test-item .d-flex {
        align-items: center;
        justify-content: space-between;
    }
    
    .test-item label {
        font-weight: 600;
        font-size: 1.1rem;
        user-select: none;
        cursor: pointer;
        margin-bottom: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .test-item input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }
    
    .controls button {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 1.25rem;
        line-height: 1;
        padding: 0 5px;
        color: #cc235e;
        transition: color 0.2s ease-in-out;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .controls button:hover {
        color: #f6b51d;
        background-color: rgba(204, 35, 94, 0.1);
    }
    
    .test-title {
        background: linear-gradient(135deg, #ac7fb6 0%, #f6b51d 100%);
        color: #fff;
        padding: 8px 12px;
        margin: 10px -15px 10px -15px;
        text-align: center;
        cursor: pointer;
        border-radius: 1rem 1rem 0 0;
        font-weight: 600;
        user-select: none;
        transition: all 0.3s ease;
    }
    
    .test-content {
        display: none;
        animation: fadeIn 0.3s ease;
    }
    
    .test-item.open .test-content {
        display: block;
    }
    
    .comment {
        margin-top: 10px;
        font-style: italic;
        color: #6267ae;
        font-size: 0.9rem;
        padding: 8px 12px;
        background-color: rgba(172, 127, 182, 0.1);
        border-radius: 0.5rem;
    }
    
    /* Table */
    table.table {
        margin-bottom: 0;
        border-collapse: separate;
        border-spacing: 0;
        border-radius: 0.5rem;
        overflow: hidden;
    }
    
    table.table thead th {
        font-weight: 600;
    }
    
    table.table td, table.table th {
        padding: 8px 10px !important;
        vertical-align: middle !important;
        font-size: 0.9rem;
        border: 1px solid #dee2e6;
    }
    
    table.table tbody tr:nth-child(even) {
        background-color: rgba(172, 127, 182, 0.05);
    }
    
    table.table tbody tr:hover {
        background-color: rgba(172, 127, 182, 0.1);
    }
    
    /* Animation */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* Print Styles */
    @media print {
        .btn, .controls, .modal {
            display: none !important;
        }
        
        .test-item {
            border: 1px solid #000;
            break-inside: avoid;
        }
        
        .test-content {
            display: block !important;
        }
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
        z-index: 1000;
        padding: 1rem;
        box-sizing: border-box;
    }

    .modal-content {
        background: rgba(255, 255, 255, 0.95);
        padding: 1.5rem;
        border-radius: 0.75rem;
        max-width: min(500px, 90vw);
        width: 100%;
        position: relative;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    }

    .modal-close {
        position: absolute;
        top: 1rem;
        right: 1rem;
        font-size: 1.5rem;
        cursor: pointer;
        color: #6c757d;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-close:hover {
        color: #dc3545;
    }

    .rejection-form {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .rejection-form label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.5rem;
    }

    .rejection-form textarea {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #dee2e6;
        border-radius: 0.5rem;
        font-size: 1rem;
        resize: vertical;
        min-height: 100px;
        box-sizing: border-box;
        backdrop-filter: blur(14px);
    }

    .rejection-form textarea:focus {
        outline: none;
        border-color: #6267ae;
        box-shadow: 0 0 0 3px rgba(98, 103, 174, 0.2);
    }

    .action-row {
        display: flex;
        gap: 0.75rem;
        justify-content: flex-end;
    }

    .action-row .btn {
        flex: 1;
        min-width: auto;
        padding: 0.5rem 1rem;
    }
</style>
@endsection
@section('scripts')
<script>
    // Function to toggle test item drawer
    function toggleDrawer(button) {
        const testItem = button.closest('.test-item');
        testItem.classList.toggle('open');
        button.textContent = testItem.classList.contains('open') ? '−' : '+';
    }

    // Function to remove a test item
    function removeTest(testId) {
        const testElement = document.getElementById(testId);
        if (testElement) {
            testElement.remove();
        }
    }

    // Function to select or deselect all test checkboxes
    function selectAllTests(check) {
        const checkboxes = document.querySelectorAll('#testContainer .test-checkbox');
        checkboxes.forEach(checkbox => checkbox.checked = check);
    }

    // Function to download reports
    function downloadReports(reports) {
        reports.forEach(report => {
            try {
                const link = document.createElement('a');
                link.href = 'data:application/pdf;base64,' + report.content;
                link.download = report.filename || 'report.pdf';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            } catch (error) {
                console.error('Error downloading report:', error);
                showToast('error', 'Failed to download report.');
            }
        });
    }

    // Function to print a PDF
    function printReport(base64Content) {
        try {
            // Create a blob from the base64 content
            const byteCharacters = atob(base64Content);
            const byteNumbers = new Array(byteCharacters.length);
            for (let i = 0; i < byteCharacters.length; i++) {
                byteNumbers[i] = byteCharacters.charCodeAt(i);
            }
            const byteArray = new Uint8Array(byteNumbers);
            const blob = new Blob([byteArray], { type: 'application/pdf' });
            const url = URL.createObjectURL(blob);

            // Create an iframe to load the PDF
            const iframe = document.createElement('iframe');
            iframe.style.display = 'none';
            iframe.src = url;
            document.body.appendChild(iframe);

            iframe.onload = () => {
                try {
                    iframe.contentWindow.focus();
                    iframe.contentWindow.print();
                    // Clean up after a delay to ensure print dialog appears
                    setTimeout(() => {
                        URL.revokeObjectURL(url);
                        document.body.removeChild(iframe);
                    }, 1000);
                } catch (error) {
                    console.error('Error printing PDF:', error);
                    showToast('error', 'Failed to initiate print.');
                }
            };

            iframe.onerror = () => {
                console.error('Error loading PDF in iframe');
                showToast('error', 'Failed to load PDF for printing.');
                URL.revokeObjectURL(url);
                document.body.removeChild(iframe);
            };
        } catch (error) {
            console.error('Error processing PDF for print:', error);
            showToast('error', 'Invalid PDF content.');
        }
    }

    // Placeholder toast function (replace with actual implementation)
    function showToast(type, message) {
        // Assuming error_toast and success_toast are defined elsewhere
        if (type === 'error') {
            if (typeof error_toast === 'function') {
                error_toast('error', message);
            } else {
                alert(message); // Fallback
            }
        } else if (type === 'success') {
            if (typeof success_toast === 'function') {
                success_toast('success', message);
            } else {
                alert(message); // Fallback
            }
        }
    }

    // Bind print button event listener
    const printBtn = document.querySelector('.print-report');
    if (printBtn && !printBtn.dataset.bound) {
        printBtn.addEventListener('click', function () {
            const selectedTestResults = Array.from(document.querySelectorAll('#testContainer .test-checkbox:checked'))
                .map(checkbox => checkbox.closest('.test-item').dataset.testResultId)
                .filter(id => id);

            if (selectedTestResults.length === 0) {
                showToast('error', 'Please select at least one test to print the report.');
                return;
            }

            console.log('Selected Test Result IDs:', selectedTestResults);

            $.ajax({
                url: '{{ route("doctor.reports.pdf") }}',
                method: 'POST',
                data: {
                    selected_test_results: selectedTestResults,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: () => {
                    printBtn.disabled = true;
                    printBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Generating...';
                },
                success: function (response) {
                    console.log('AJAX Success:', response);
                    if (response.reports && Array.isArray(response.reports) && response.reports.length > 0) {
                        downloadReports(response.reports);
                        showToast('success', 'Report generated successfully. Check your downloads.');
                        // if (response.reports[0].content) {
                        //     printReport(response.reports[0].content);
                        // } else {
                        //     showToast('error', 'No valid PDF content found in the response.');
                        // }
                    } else {
                        showToast('error', 'No reports generated. Please try again.');
                    }
                },
                error: function (xhr) {
                    console.error('AJAX Error:', xhr.responseText);
                    let errorMessage = 'Failed to generate the report. Please try again.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    showToast('error', errorMessage);
                },
                complete: () => {
                    printBtn.disabled = false;
                    printBtn.innerHTML = '<i class="fas fa-print me-2"></i> Print';
                }
            });
        });

        printBtn.dataset.bound = 'true';
    }

    // Approve Report AJAX
    function approveReport(reportId) {
        if (confirm('Are you sure you want to approve this report?')) {
            $.ajax({
                url: `/doctor/reports/approve/${reportId}`,
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.success) {
                        alert('Report approved successfully!');
                        window.history.back();
                    } else {
                        alert('Error approving report: ' + (data.message || 'Unknown error'));
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr);
                    alert('An error occurred while approving the report.');
                }
            });
        }
    }


    // Re-Approve Report (for rejected)
    function reApproveReport(reportId){
        if (confirm('Are you sure you want to re-approve this rejected report?')) {
            fetch(`/doctor/reports/approve/${reportId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Report re-approved successfully!');
                    location.reload(); // Reload to update tabs and stats
                } else {
                    alert('Error re-approving report: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while re-approving the report.');
            });
        }
    }

   // Sign Report AJAX
    function signReport(reportId) {
        if (confirm('Are you sure you want to sign this report?')) {
            fetch(`/doctor/reports/sign/${reportId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Report signed successfully!');
                    // Optionally, remove the card or reload the page
                    const card = document.querySelector(`[data-report-id="${reportId}"]`);
                    if (card) {
                        card.remove();
                    }
                    // Update stats if needed (you can add logic here)
                    location.reload(); // Simple reload for now
                } else {
                    alert('Error signing report: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while signing the report.');
            });
        }
    }

    // Rejection Modal Functionality
    function openRejectionModal(reportId) {
        document.getElementById('rejectReportId').value = reportId;
        document.getElementById('rejectionReason').value = ''; // Clear previous input
        document.getElementById('rejectionModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
        document.getElementById('rejectionReason').focus();
    }

    function closeRejectionModal() {
        document.getElementById('rejectionModal').style.display = 'none';
        document.body.style.overflow = '';
        document.getElementById('rejectionForm').reset();
    }

    // Handle Rejection Form Submit
    document.getElementById('rejectionForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const reportId = document.getElementById('rejectReportId').value;
        const reason = document.getElementById('rejectionReason').value.trim();

        if (!reason) {
            alert('Please provide a rejection reason.');
            return;
        }

        $.ajax({
            url: `/doctor/reports/reject/${reportId}`,
            method: 'POST',
            data: {
                reason: reason,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.success) {
                    alert('Report rejected successfully!');
                    closeRejectionModal();
                    window.history.back();
                } else {
                    alert('Error rejecting report: ' + (data.message || 'Unknown error'));
                }
            },
            error: function(xhr) {
                console.error('Error:', xhr);
                alert('An error occurred while rejecting the report.');
            }
        });
    });

    // Close modal when clicking outside
    window.onclick = function(event) {
        const rejectionModal = document.getElementById('rejectionModal');
        if (event.target === rejectionModal) {
            closeRejectionModal();
        }
    }

    // Close on Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeRejectionModal();
        }
    });

    // Keyboard shortcuts
    document.addEventListener('keydown', function (e) {
        if (e.ctrlKey && e.key === 'a') {
            e.preventDefault();
            selectAllTests(true);
        }
        if (e.ctrlKey && e.key === 'd') {
            e.preventDefault();
            selectAllTests(false);
        }
        if (e.ctrlKey && e.key === 'p') {
            e.preventDefault();
            const btn = document.querySelector('.print-report');
            if (btn) btn.click();
        }
    });
</script>
@endsection
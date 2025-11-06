@extends('Admin.Layouts.layout')

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
                <a href="{{ url('admin/report') }}" 
                   class="btn btn-light btn-lg mt-3 fw-semibold rounded-pill shadow-sm"
                   style="background: #f6b51d; color: #1f2937; border: none;">
                    <i class="mdi mdi-arrow-left me-2"></i> Back
                </a>
                <div class="position-absolute top-0 end-0 opacity-25" style="font-size: 120px; color: #ac7fb6;">
                    <i class="mdi mdi-flask"></i>
                </div>
            </div>

            {{-- Show rejection reason --}}
            @php
                $status = $report->first()?->status ?? '';
                $reason = $report->first()?->rejection_reason ?? '';
            @endphp
            @if($status === 'rejected' && !empty($reason))
                <div class="alert alert-danger mt-4 rounded-3 shadow-sm">
                    <strong>Rejection Reason:</strong> {{ $reason }}
                </div>
            @endif

            {{-- Controls --}}
            <div class="mt-4 mb-3">
                <div class="d-flex flex-wrap gap-2">
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

                    {{-- ✅ Working Print Button --}}
                    <button class="btn btn-light btn-lg fw-semibold rounded-pill shadow-sm print-report"
                            style="background: #f6b51d; color: #1f2937; border: none;">
                        <i class="fas fa-print me-2"></i> Print
                    </button>

                    <button id="animalInfo" class="btn btn-light btn-lg fw-semibold rounded-pill shadow-sm"
                            style="background: #cc235e; color: #fff; border: none;"
                            data-bs-toggle="modal" data-bs-target="#animalInfoModal">
                        <i class="mdi mdi-paw me-2"></i> Animal info
                    </button>

                    {{-- ✅ Action Buttons --}}
                    <a href="{{ route('reports.generate', $id) }}" 
                       class="btn btn-light btn-lg fw-semibold rounded-pill shadow-sm"
                       style="background: #ffc107; color: #1f2937; border: none;">
                       <i class="fas fa-edit me-2"></i> Edit
                    </a>

                    <button class="btn btn-light btn-lg fw-semibold rounded-pill shadow-sm approve-btn"
                            data-id="{{ $id }}"
                            style="background: #28a745; color: #fff; border: none;">
                        <i class="fas fa-check-circle me-2"></i> Approve
                    </button>

                    <button class="btn btn-light btn-lg fw-semibold rounded-pill shadow-sm reject-btn"
                            data-id="{{ $id }}"
                            style="background: #dc3545; color: #fff; border: none;">
                        <i class="fas fa-times-circle me-2"></i> Reject
                    </button>

                    {{-- <button class="btn btn-light btn-lg fw-semibold rounded-pill shadow-sm sign-btn"
                            data-id="{{ $id }}"
                            style="background: #0d6efd; color: #fff; border: none;">
                        <i class="fas fa-signature me-2"></i> Sign
                    </button> --}}
                </div>
            </div>

            {{-- Tests --}}
            <div class="mb-3 px-3 py-2 rounded-3"
                 style="background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%); color: #fff; font-weight: 600;">
                Tests
            </div>

            <div id="testContainer">
                @if(!empty($tests))
                    @foreach($tests as $test)
                        @php
                            $testResult = $report->where('test_id', $test->id)->first();
                        @endphp
                        <div class="test-item" id="test{{ $test->id }}" data-test-result-id="{{ $testResult?->id }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <label>
                                    <input type="checkbox" class="test-checkbox">
                                    {{ $test->name ?? 'Test Name' }}
                                </label>
                                <div class="controls">
                                    <button class="toggle-btn shadow-sm" onclick="toggleDrawer(this)">
                                        <i class="mdi mdi-chevron-down"></i>
                                    </button>
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
                                            @if($parameter->row_type === 'component')
                                                @php
                                                    $component = $testResult?->components->where('component_id', $parameter->id)->first();
                                                @endphp
                                                <tr>
                                                    <td>{{ $parameter->name ?? 'Parameter Name' }}</td>
                                                    <td>{{ $component?->result ?? 'N/A' }}</td>
                                                    <td>{{ $parameter->unit ?? 'Unit' }}</td>
                                                    <td>{{ $parameter->reference_range ?? $parameter->normal_range ?? 'Normal Range' }}</td>
                                                    <td>{{ $component?->result_status ?? 'N/A' }}</td>
                                                </tr>
                                            @endif
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted">No parameters found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="comment">Comment: {{ $testResult?->comment ?? 'No comment available' }}</div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>

{{-- ✅ Animal Info Modal --}}
<div class="modal fade" id="animalInfoModal" tabindex="-1" aria-labelledby="animalInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4" style="background: rgba(255,255,255,0.85); backdrop-filter: blur(14px);">
            <div class="modal-header" style="background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%); color: #fff;">
                <h5 class="modal-title" id="animalInfoModalLabel">Animal Info</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p><strong>Name:</strong> {{ $appointment->pet->name ?? 'N/A' }}</p>
                <p><strong>Gender:</strong> {{ $appointment->pet->gender ?? 'N/A' }}</p>
                <p><strong>Age:</strong> {{ $appointment->pet->age ?? 'N/A' }}</p>
                <p><strong>Owner Name:</strong> {{ $appointment->pet->petparent->name ?? 'N/A' }}</p>
                <p><strong>Phone:</strong> {{ $appointment->pet->petparent->mobile ?? 'N/A' }}</p>
                <p><strong>Email:</strong> {{ $appointment->pet->petparent->email ?? 'N/A' }}</p>
                <p><strong>Address:</strong> {{ $appointment->pet->petparent->address ?? 'N/A' }}</p>
            </div>
        </div>
    </div>
</div>

{{-- ✅ Rejection Modal (Doctor Style) --}}
<div class="modal fade" id="rejectionModal" tabindex="-1" aria-labelledby="rejectionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow-lg border-0">
            <div class="modal-header" style="background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%); color: #fff;">
                <h5 class="modal-title fw-bold" id="rejectionModalLabel">Reject Report</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="rejectionForm">
                @csrf
                <div class="modal-body p-4">
                    <input type="hidden" id="rejectReportCode" name="report_code">
                    <div class="mb-3">
                        <label for="rejectionReason" class="form-label fw-semibold" style="color:#6267ae;">Enter Rejection Reason</label>
                        <textarea id="rejectionReason" name="reason" class="form-control rounded-3 shadow-sm" rows="4" placeholder="Enter reason..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary rounded-pill px-4 shadow-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger rounded-pill px-4 shadow-sm">Reject</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.test-item {
    border: 2px solid #ac7fb6;
    margin-bottom: 15px;
    padding: 10px 15px;
    border-radius: 1rem;
    background: rgba(255,255,255,0.85);
    backdrop-filter: blur(14px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
.test-item:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
.toggle-btn {
    background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%);
    color: #fff; border: none; border-radius: 50%; width: 38px; height: 38px;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 18px; cursor: pointer; transition: all 0.3s ease;
    box-shadow: 0 2px 6px rgba(0,0,0,0.2);
}
.toggle-btn:hover {
    transform: scale(1.1);
    background: linear-gradient(135deg, #cc235e 0%, #f6b51d 100%);
    box-shadow: 0 3px 8px rgba(0,0,0,0.25);
}
.test-item.open .toggle-btn i {
    transform: rotate(180deg); transition: transform 0.3s ease;
}
.test-content { display: none; }
.test-item.open .test-content { display: block; }
.comment { color: #6267ae; font-style: italic; font-size: 0.9rem; background: rgba(172,127,182,0.1); border-radius: .5rem; padding: 8px; }

textarea:focus {
    outline: none;
    border-color: #6267ae !important;
    box-shadow: 0 0 0 3px rgba(98,103,174,0.3) !important;
}
</style>
@endsection

@section('scripts')
<script>
function toggleDrawer(button) {
    const testItem = button.closest('.test-item');
    testItem.classList.toggle('open');
    const icon = button.querySelector('i');
    icon.classList.toggle('mdi-chevron-down');
    icon.classList.toggle('mdi-chevron-up');
}

function selectAllTests(check) {
    document.querySelectorAll('#testContainer .test-checkbox').forEach(cb => cb.checked = check);
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

// Placeholder toast function (replace with actual implementation)
function showToast(type, message) {
    // Assuming toastr is available, or fallback to alert
    if (type === 'error') {
        if (typeof toastr !== 'undefined') {
            toastr.error(message);
        } else {
            alert(message); // Fallback
        }
    } else if (type === 'success') {
        if (typeof toastr !== 'undefined') {
            toastr.success(message);
        } else {
            alert(message); // Fallback
        }
    }
}

// ✅ Updated Print Functionality (Same as Branch Logic)
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
            url: '{{ route("reports.pdf") }}', // Adjust route name as per your admin PDF generation route
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

$(document).ready(function() {

    // ✅ To prevent multiple bindings — always clear old ones first
    $(document).off('click', '.approve-btn')
                .off('click', '.reject-btn')
                .off('click', '.sign-btn')
                .off('click', '.reapprove-btn');

    // ✅ Approve Report
    $(document).on('click', '.approve-btn', function(e) {
        e.preventDefault();
        const code = $(this).data('id');
        if (!confirm('Approve this report?')) return;
        $.post(`/admin/reports/approve/${code}`, {
            _token: $('meta[name="csrf-token"]').attr('content')
        }).done(res => {
            toastr.success(res.message);
            window.location.reload(); // Reload page to reflect changes
        }).fail(() => toastr.error('Approval failed.'));
    });

    // ✅ Reject Report (Open modal)
    $(document).on('click', '.reject-btn', function(e) {
        e.preventDefault();
        const code = $(this).data('id');
        $('#rejectReportCode').val(code);
        $('#rejectionModal').modal('show');
    });

    // ✅ Submit Rejection
    $('#rejectionForm').off('submit').on('submit', function(e) {
        e.preventDefault();
        const code = $('#rejectReportCode').val();
        const reason = $('#rejectionReason').val().trim();
        if (!reason) return toastr.error('Please enter a reason.');
        $.ajax({
            url: `/admin/reports/reject/${code}`,
            type: 'POST',
            data: { _token: $('meta[name="csrf-token"]').attr('content'), reason },
            success: res => {
                toastr.warning(res.message);
                $('#rejectionModal').modal('hide');
                window.location.reload(); // Reload page to reflect changes
            },
            error: () => toastr.error('Rejection failed.')
        });
    });

    // ✅ Clear modal on close
    $('#rejectionModal').on('hidden.bs.modal', function() {
        $('#rejectionForm')[0].reset();
        $('#rejectReportCode').val('');
    });

    // ✅ Sign Report
    $(document).on('click', '.sign-btn', function(e) {
        e.preventDefault();
        const code = $(this).data('id');
        if (!confirm('Sign this report?')) return;
        $.post(`/admin/reports/sign/${code}`, { 
            _token: $('meta[name="csrf-token"]').attr('content') 
        })
        .done(() => { toastr.success('Signed!'); window.location.reload(); })
        .fail(() => toastr.error('Sign failed.'));
    });

    // ✅ Re-Approve Report
    $(document).on('click', '.reapprove-btn', function(e) {
        e.preventDefault();
        const code = $(this).data('id');
        if (!confirm('Re-approve this report?')) return;
        $.post(`/admin/reports/reopen/${code}`, { 
            _token: $('meta[name="csrf-token"]').attr('content') 
        })
        .done(res => { toastr.success(res.message); window.location.reload(); })
        .fail(() => toastr.error('Failed to re-approve.'));
    });

});
</script>
@endsection
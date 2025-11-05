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

            {{-- Show rejection reason if report is rejected --}}
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
                <span class="text-secondary fw-semibold d-block mb-2">
                    Select tests and cultures to be printed in the report
                </span>
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
                    <button class="btn btn-light btn-lg fw-semibold rounded-pill shadow-sm print-report"
                            style="background: #f6b51d; color: #1f2937; border: none;">
                        <i class="fas fa-print me-2"></i> Print
                    </button>
                    <button id="animalInfo" class="btn btn-light btn-lg fw-semibold rounded-pill shadow-sm ms-2"
                            style="background: #cc235e; color: #fff; border: none;"
                            data-bs-toggle="modal" data-bs-target="#animalInfoModal">
                        <i class="mdi mdi-paw me-2"></i> Animal info
                    </button>

                    {{-- ✅ Action Buttons with data-id --}}
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
                    <button class="btn btn-light btn-lg fw-semibold rounded-pill shadow-sm sign-btn"
                            data-id="{{ $id }}"
                            style="background: #0d6efd; color: #fff; border: none;">
                        <i class="fas fa-signature me-2"></i> Sign
                    </button>
                </div>
            </div>

            {{-- Tests --}}
            <div class="mb-3 px-3 py-2 rounded-3"
                 style="background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%); color: #fff; font-weight: 600;">
                Tests
            </div>

            <div id="testContainer">
                @if(!empty($tests))
                    @foreach($tests as $index => $test)
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
                                                <td colspan="5" class="text-center text-muted">
                                                    No parameters found
                                                </td>
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

{{-- Animal Info Modal --}}
@include('Admin.Reports.partials.animal-info-modal', ['appointment' => $appointment])

{{-- Styles (unchanged) --}}
<style>/* (Keep your existing styles here) */</style>
@endsection

@section('scripts')
{{-- ✅ Include SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function toggleDrawer(button) {
        const testItem = button.closest('.test-item');
        testItem.classList.toggle('open');
        button.textContent = testItem.classList.contains('open') ? '−' : '+';
    }

    function removeTest(id) {
        document.getElementById(id)?.remove();
    }

    function selectAllTests(check) {
        document.querySelectorAll('#testContainer .test-checkbox').forEach(cb => cb.checked = check);
    }

    // ✅ Sign Report
    $(document).on('click', '.sign-btn', function() {
        const code = $(this).data('id');
        Swal.fire({
            title: 'Sign Report?',
            text: 'Once signed, report will be marked as completed.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, Sign',
            confirmButtonColor: '#0d6efd',
            cancelButtonColor: '#6c757d'
        }).then(result => {
            if (result.isConfirmed) {
                $.post(`/admin/reports/sign/${code}`, { _token: $('meta[name="csrf-token"]').attr('content') })
                    .done(res => { toastr.success(res.message); })
                    .fail(err => toastr.error(err.responseJSON?.message || 'Sign failed.'));
            }
        });
    });

    // ✅ Approve Report
    $(document).on('click', '.approve-btn', function() {
        const code = $(this).data('id');
        Swal.fire({
            title: 'Approve Report?',
            text: 'This will mark the report as approved.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Approve',
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d'
        }).then(result => {
            if (result.isConfirmed) {
                $.post(`/admin/reports/approve/${code}`, { _token: $('meta[name="csrf-token"]').attr('content') })
                    .done(res => { toastr.success(res.message); })
                    .fail(err => toastr.error(err.responseJSON?.message || 'Approval failed.'));
            }
        });
    });

    // ❌ Reject Report (with reason)
    $(document).on('click', '.reject-btn', function() {
        const code = $(this).data('id');
        Swal.fire({
            title: 'Reject Report',
            input: 'textarea',
            inputLabel: 'Enter rejection reason',
            inputPlaceholder: 'Type reason here...',
            showCancelButton: true,
            confirmButtonText: 'Reject',
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            preConfirm: (reason) => {
                if (!reason) {
                    Swal.showValidationMessage('Please enter a rejection reason.');
                }
                return reason;
            }
        }).then(result => {
            if (result.isConfirmed) {
                $.post(`/admin/reports/reject/${code}`, {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    reason: result.value
                })
                .done(res => { toastr.warning(res.message); })
                .fail(err => toastr.error(err.responseJSON?.message || 'Rejection failed.'));
            }
        });
    });
</script>
@endsection

@extends('Admin.Layouts.layout')

@section('meta_title', 'Test Reports | ChromoXpert')

@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">

            {{-- Hero Header --}}
            <div class="p-4 rounded-4 mb-4 position-relative overflow-hidden shadow-lg"
                 style="background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%); color: #fff;">
                <h2 class="fw-bold mb-1">Test Reports</h2>
                <p class="mb-0">Manage and view all laboratory test reports</p>
                <div class="position-absolute top-0 end-0 opacity-25" style="font-size: 120px; color: #ac7fb6;">
                    <i class="mdi mdi-file-document"></i>
                </div>
            </div>
            
            {{-- Search + Filter --}}
            <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                <!-- Search Input -->
                <div class="input-group rounded-pill shadow-sm" 
                    style="max-width: 300px; background: #fff; border: 1px solid #f6b51d; overflow: hidden;">
                    <span class="input-group-text bg-transparent border-0 pe-2">
                        <i class="mdi mdi-magnify" style="color: #6267ae; font-size: 18px;"></i>
                    </span>
                    <input type="search" id="searchInput" 
                        class="form-control border-0 ps-1" 
                        placeholder="Search reports..." 
                        style="color: #6267ae; padding-top:9px; padding-bottom:9px; box-shadow: none;">
                </div>

                <!-- Status Filter -->
                <select id="statusFilter" 
                        class="form-select rounded-pill shadow-sm" 
                        style="max-width: 200px; background: #fff; color: #6267ae; border: 1px solid #f6b51d; padding-top:9px; padding-bottom:9px;">
                    <option value="all">All Status</option>
                    <option value="completed">Completed</option>
                    <option value="pending">Pending</option>
                    <option value="in_progress">In Progress</option>
                </select>
            </div>

            {{-- Table --}}
            <div class="card border-0 shadow-lg rounded-4"
                 style="background: rgba(255,255,255,0.85); backdrop-filter: blur(14px);">
                <div class="card-body p-3">
                    <div class="table-responsive">
                        <table id="cims_data_table" class="table align-middle table-hover">
                            <thead style="background: linear-gradient(135deg, #ac7fb6 0%, #f6b51d 100%); color: #fff;">
                                <tr>
                                    <th>#</th>
                                    <th>Code</th>
                                    <th>Patient Code</th>
                                    <th>Patient Name</th>
                                    <th>Pet Parent</th>
                                    <th>Mobile</th>
                                    <th>Tests</th>
                                    <th>Appointment Date</th>
                                    <th>Status</th>
                                    <th>Assigned Doctor</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
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

{{-- ✅ Assign Doctor Modal --}}
<div class="modal fade" id="assignDoctorModal" tabindex="-1" aria-labelledby="assignDoctorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow-lg border-0">
            <div class="modal-header" style="background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%); color: #fff;">
                <h5 class="modal-title fw-bold" id="assignDoctorModalLabel">Assign to Doctor</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="assignDoctorForm">
                @csrf
                <div class="modal-body p-4">
                    <input type="hidden" id="assignTestResultCode" name="test_result_code">
                    <div class="mb-3">
                        <label for="doctorSelect" class="form-label fw-semibold" style="color:#6267ae;">Select Doctor</label>
                        <select id="doctorSelect" name="doctor_id" class="form-select rounded-3 shadow-sm" required>
                            <option value="">Choose a doctor...</option>
                            @foreach(\App\Models\InternalDoctor::where('status', 'active')->get() as $doctor)
                                <option value="{{ $doctor->id }}">{{ $doctor->doctor_name }} ({{ $doctor->mobile ?? 'N/A' }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-danger rounded-pill shadow-sm px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill shadow-sm px-4">
                        <i class="mdi mdi-check me-1"></i> Assign
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('style')
<style>
    .btn-icon {
        border-radius: 50%;
        width: 38px;
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease-in-out;
    }
    .btn-icon:hover { transform: scale(1.15); }

    .fade-in-row { animation: fadeInUp 0.6s ease-in-out; }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    textarea:focus {
        outline: none;
        border-color: #6267ae !important;
        box-shadow: 0 0 0 3px rgba(98,103,174,0.3) !important;
    }
</style>
@endsection
@section('scripts')
<script>
$(document).ready(function() {

    // ✅ Initialize DataTable safely
    if ($.fn.DataTable.isDataTable('#cims_data_table')) {
        $('#cims_data_table').DataTable().destroy();
    }

    const table = $('#cims_data_table').DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        ajax: base_url + "/admin/report/data-table",
        columns: [
            { data: 'DT_RowIndex' },
            { data: 'test_result_code' },
            { data: 'pet_code' },
            { data: 'pet_name' },
            { data: 'pet_parent' },
            { data: 'pet_parent_mobile' },
            { data: 'tests' },
            { data: 'appointment_datetime' },
            { data: 'status' },
            { data: 'assigned_doctor' },
            { data: 'action', orderable: false, searchable: false }
        ]
    });

    window.reload_table = () => table.ajax.reload(null, false);

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
            reload_table();
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
                reload_table();
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
        .done(() => { toastr.success('Signed!'); reload_table(); })
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
        .done(res => { toastr.success(res.message); reload_table(); })
        .fail(() => toastr.error('Failed to re-approve.'));
    });

});
</script>
@endsection

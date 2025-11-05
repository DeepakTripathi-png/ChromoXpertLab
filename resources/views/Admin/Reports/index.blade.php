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


            {{-- Glassmorphic Table Card --}}
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
                                    <th>Pet parent/owner Name</th>
                                    <th>Pet parent/owner Mobile</th>
                                    <th>Tests</th>
                                    <th>Appointment Date</th>
                                    <th>Status</th>
                                    {{-- <th>Done</th>
                                    <th>Signed</th> --}}
                                    <th>Assigned Doctor</th>
                                    <th class="text-center">Action</th> 
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>

            

                </div>
            </div>



        </div>
    </div>
</div>

{{-- Existing Barcode Modal --}}
<div class="modal fade" id="barcodeModal" tabindex="-1" aria-labelledby="barcodeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow-lg" style="border: none;">
            <div class="modal-header" style="background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%); color: #fff;">
                <h5 class="modal-title fw-bold" id="barcodeModalLabel">Print Barcode</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label for="sampleCount" class="form-label fw-semibold" style="color:#6267ae;">Number of samples</label>
                    <input type="number" id="sampleCount" class="form-control rounded-3 shadow-sm" min="1" value="1">
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-danger rounded-pill shadow-sm px-4" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-warning rounded-pill shadow-sm px-4" id="printBarcodeBtn">
                    <i class="mdi mdi-printer me-1"></i> Print
                </button>
            </div>
        </div>
    </div>
</div>

{{-- New Assign Doctor Modal --}}
<div class="modal fade" id="assignDoctorModal" tabindex="-1" aria-labelledby="assignDoctorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow-lg" style="border: none;">
            <div class="modal-header" style="background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%); color: #fff;">
                <h5 class="modal-title fw-bold" id="assignDoctorModalLabel">Assign to Doctor</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="assignDoctorForm">
                @csrf
                <div class="modal-body p-4">
                    <input type="hidden" id="assignTestResultCode" name="test_result_code" value="">
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

    .custom-pagination .page-link {
        border-radius: 50%;
        margin: 0 4px;
        padding: 8px 14px;
        color: #6267ae;
        font-weight: 600;
        border: none;
        background: rgba(255,255,255,0.9);
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    .custom-pagination .page-link:hover {
        background: #f6b51d;
        color: #fff;
    }
    .custom-pagination .active .page-link {
        background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%);
        color: #fff;
    }

    .table > thead th {
        border-bottom: none;
        font-weight: 600;
    }

    .alert {
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
</style>
@endsection

@section('scripts')
<script src="{{ URL::asset('admin_panel\controller_js\cn_report.js') }}"></script>
<script>
    // Combined search and filter function
    function applyFilters() {
        let searchFilter = document.getElementById('searchInput').value.toLowerCase();
        let statusFilter = document.getElementById('statusFilter').value.toLowerCase();

        document.querySelectorAll('#cims_data_table tbody tr').forEach(function(row) {
            let text = row.innerText.toLowerCase();
            let status = row.querySelector('.badge') ? row.querySelector('.badge').innerText.toLowerCase() : '';

            let matchesSearch = text.includes(searchFilter);
            let matchesStatus = (statusFilter === 'all' || status === statusFilter);

            row.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
        });
    }

    // Debounced search
    let debounceTimer;
    document.getElementById('searchInput').addEventListener('keyup', function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(applyFilters, 300);
    });

    // Status filter
    document.getElementById('statusFilter').addEventListener('change', applyFilters);

    $(document).ready(function() {
        // ============================
        // 🔹 DataTable Initialization (from your provided JS)
        // ============================
        var table = $('#cims_data_table');
        if ($.fn.DataTable.isDataTable('#cims_data_table')) {
            table.DataTable().destroy();
        }
        table = $('#cims_data_table').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            ajax: base_url + "/admin/report/data-table",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'test_result_code', name: 'test_result_code' },
                { data: 'pet_code', name: 'pet_code' },
                { data: 'pet_name', name: 'pet_name' },
                { data: 'pet_parent', name: 'pet_parent' },
                { data: 'pet_parent_mobile', name: 'pet_parent_mobile' },
                { data: 'tests', name: 'tests' },
                { data: 'appointment_datetime', name: 'appointment_datetime' },
                { data: 'status', name: 'status', orderable: false, searchable: false },
                // { data: 'done', name: 'done' },
                // { data: 'signed', name: 'signed' },
                { data: 'assigned_doctor', name: 'assigned_doctor' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        // ============================
        // 🔹 Global Reload Function (Made Global for Accessibility)
        // ============================
        window.reload_table = function() {
            if ($.fn.DataTable.isDataTable('#cims_data_table')) {
                $('#cims_data_table').DataTable().ajax.reload(null, false);
            }
        };

        // ============================
        // 🔹 Assign Doctor Modal & Form (de-duped, cleaned)
        // ============================
        $(document).on('click', '.assign-doctor-btn', function() {
            const id = $(this).data('id');
            $('#assignTestResultCode').val(id);
            $('#assignDoctorModal').modal('show');
        });

        $('#assignDoctorForm').on('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const testResultCode = $('#assignTestResultCode').val();

            $.ajax({
                url: "{{ route('reports.assignDoctor', '') }}/" + testResultCode,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#assignDoctorForm button[type="submit"]').prop('disabled', true).text('Assigning...');
                },
                success: function(response) {
                    $('#assignDoctorModal').modal('hide');
                    toastr.success(response.message || 'Doctor assigned successfully!');
                    
                    // Force reload with a small delay to ensure modal is fully closed
                    setTimeout(function() {
                        window.reload_table();
                    }, 500);
                },
                error: function(xhr) {
                    toastr.error(xhr.responseJSON?.message || 'Assignment failed.');
                },
                complete: function() {
                    $('#assignDoctorForm button[type="submit"]').prop('disabled', false).text('Assign');
                }
            });
        });

        // ============================
        // 🔹 Barcode Modal Print Button Handler (NEW)
        // ============================
        // Optional: Auto-set sample count or id when modal opens
        $('#barcodeModal').on('shown.bs.modal', function() {
            const testResultCode = $('#barcodeModal').data('test-result-code') || '';  // Set via data attr on trigger
            // You can pre-fill or use this for AJAX
        });

        $('#printBarcodeBtn').on('click', function() {
            const testResultCode = $('#barcodeModal').data('test-result-code') || '';
            const sampleCount = $('#sampleCount').val() || 1;

            if (!testResultCode) {
                toastr.error('No report selected.');
                return;
            }

            // AJAX to backend for barcode generation (adjust route/method as needed)
            // Example: Generate PDF/image and download/print
            $.ajax({
                url: "{{ url('admin/test-report/barcode') }}/" + testResultCode,  // Your backend route
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    sample_count: sampleCount
                },
                success: function(response) {
                    // Assuming backend returns PDF base64 or URL
                    if (response.pdf_content) {  // Base64 PDF like in your reportPdf method
                        const link = document.createElement('a');
                        link.href = 'data:application/pdf;base64,' + response.pdf_content;
                        link.download = 'barcode_' + testResultCode + '_' + new Date().getTime() + '.pdf';
                        link.click();
                        toastr.success('Barcode PDF downloaded!');
                    } else {
                        // Fallback: Open print dialog (if backend returns HTML/image)
                        const printWindow = window.open('', '_blank');
                        printWindow.document.write(response.html || '<p>Barcode generated - printing...</p>');
                        printWindow.print();
                    }
                    $('#barcodeModal').modal('hide');
                },
                error: function() {
                    toastr.error('Failed to generate barcode.');
                }
            });
        });

        // ============================
        // 🔹 Reset Modals on Hide
        // ============================
        $('#assignDoctorModal, #barcodeModal').on('hidden.bs.modal', function() {
            $(this).find('form').trigger('reset');  // Reset forms
            $('#sampleCount').val(1);  // Reset sample count
        });

        // ============================
        // 🔹 Optional: Specific Download Handler (if you add .download-report-btn later)
        // ============================
        $(document).on('click', '.download-report-btn', function(e) {
            e.preventDefault();
            const reportId = $(this).data('id');  // Use data-id
            // Real download logic, e.g., AJAX to reportPdf method
            window.open("{{ url('admin/report/pdf') }}?selected_test_results[]=" + reportId, '_blank');
            toastr.success('PDF download started!');
        });

        // Remove old generic handlers (no more .btn-primary or .btn-danger conflicts)
    });



        $(document).on('click', '.sign-btn', function() {
                    if (!confirm('Sign this report?')) return;
                    const code = $(this).data('id');
                    alert(code);
                    $.post(`/admin/reports/sign/${code}`, { 
                        _token: $('meta[name="csrf-token"]').attr('content') 
                    })
                    .done(() => { 
                        toastr.success('Signed!'); 
                        window.reload_table(); 
                    })
                    .fail(() => toastr.error('Sign failed.'));
        });


        //  Approve Report
            $(document).on('click', '.approve-btn', function() {
                if (!confirm('Are you sure you want to approve this report?')) return;
                const code = $(this).data('id');
                $.post(`/admin/reports/approve/${code}`, {
                    _token: $('meta[name="csrf-token"]').attr('content')
                })
                .done(res => {
                    toastr.success(res.message);
                    window.reload_table(); // reload datatable
                })
                .fail(err => toastr.error(err.responseJSON?.message || 'Approval failed.'));
            });


        //  Reject Report
            $(document).on('click', '.reject-btn', function() {
                if (!confirm('Are you sure you want to reject this report?')) return;
                const code = $(this).data('id');
                $.post(`/admin/reports/reject/${code}`, {
                    _token: $('meta[name="csrf-token"]').attr('content')
                })
                .done(res => {
                    toastr.warning(res.message);
                    window.reload_table(); // reload datatable
                })
                .fail(err => toastr.error(err.responseJSON?.message || 'Rejection failed.'));
            });


</script>
@endsection
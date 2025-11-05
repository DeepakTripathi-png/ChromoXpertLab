@extends('Doctor.Layouts.layout')

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

            {{-- Alerts --}}
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                <i class="mdi mdi-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                <i class="mdi mdi-alert-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

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
                                    {{-- <th>Done</th> --}}
                                    {{-- <th>Signed</th> --}}
                                    {{-- <th>Assigned Doctor</th> --}}
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
                <button type="button" class="btn btn-danger rounded-pill shadow-sm px-4 modal-barcode-close" data-bs-dismiss="modal">Close</button>
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
                    <button type="button" class="btn btn-danger rounded-pill shadow-sm px-4 modal-assign-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success rounded-pill shadow-sm px-4 modal-assign-submit">  {{-- btn-success + unique class --}}
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
<script src="{{ URL::asset('doctor\controller_js\cn_report.js') }}"></script>
<script>
$(document).ready(function() {
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
    if (document.getElementById('searchInput')) {
        document.getElementById('searchInput').addEventListener('keyup', function() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(applyFilters, 300);
        });
    }

    // Status filter
    if (document.getElementById('statusFilter')) {
        document.getElementById('statusFilter').addEventListener('change', applyFilters);
    }

    // Table-specific delete (scoped to table only)
    $(document).on('click', '#cims_data_table .btn-danger', function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();  // Stop all propagation to prevent duplicates
        if (confirm('Are you sure you want to delete this report?')) {
            var id = $(this).data('id');
            var table = $(this).data('table');
            var flash_message = $(this).data('flash') || 'Report deleted successfully!';
            // Simulate or real AJAX here
            toastr.success(flash_message);
            $(this).closest('tr').remove();
            $('#cims_data_table tbody tr').each(function(index) {
                $(this).find('td:first').text(index + 1);
            });
            applyFilters();
        }
    });

    // Table-specific download (scoped to table only; avoids modal conflicts)
    $(document).on('click', '#cims_data_table .btn-primary', function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var reportId = $(this).closest('tr').find('td:nth-child(2)').text() || 'Unknown';
        toastr.info('Downloading report: ' + reportId + '.pdf');
        // Add real download logic if needed
    });

    // Assign Doctor Modal Trigger (unique class already)
    $(document).on('click', '.assign-doctor-btn', function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        const id = $(this).data('id');
        if (!id) {
            toastr.error('Invalid report ID.');
            return;
        }
        $('#assignTestResultCode').val(id);
        $('#assignDoctorModal').modal('show');
    });

    // Assign Doctor Submit (unique class; click handler to avoid form submit duplicates)
    $(document).on('click', '.modal-assign-submit', function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        const form = $('#assignDoctorForm')[0];
        const formData = new FormData(form);
        const testResultCode = $('#assignTestResultCode').val();
        const doctorId = $('#doctorSelect').val();

        if (!testResultCode) {
            toastr.error('Invalid report code.');
            return;
        }
        if (!doctorId) {
            toastr.error('Please select a doctor.');
            $('#doctorSelect').focus();
            return;
        }

        const submitBtn = $(this);
        submitBtn.prop('disabled', true).html('<i class="mdi mdi-loading spinner-border spinner-border-sm me-1"></i>Assigning...');  // Visual feedback

        // Single AJAX call - no duplicates
        $.ajax({
            url: "{{ url('doctor/reports/assign-doctor') }}/" + testResultCode,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log('Assign Success (single call):', response);  // Debug: Confirm single fire
                $('#assignDoctorModal').modal('hide');
                toastr.success(response.message || 'Doctor assigned successfully!');  // Single toastr here
                
                // Reload table - single call
                setTimeout(function() {
                    if (typeof window.reload_table === 'function') {
                        window.reload_table();
                    } else if ($.fn.DataTable.isDataTable('#cims_data_table')) {
                        $('#cims_data_table').DataTable().ajax.reload(null, false);
                    } else {
                        location.reload();
                    }
                }, 500);
            },
            error: function(xhr) {
                console.error('Assign Error (single call):', xhr);  // Debug
                let errorMsg = 'Assignment failed.';
                if (xhr.status === 403) errorMsg = 'No permission.';
                else if (xhr.status === 404) errorMsg = 'Report not found.';
                else if (xhr.responseJSON?.message) errorMsg = xhr.responseJSON.message;
                toastr.error(errorMsg);
            },
            complete: function() {
                submitBtn.prop('disabled', false).html('<i class="mdi mdi-check me-1"></i>Assign');
            }
        });
    });

    // Barcode Print (unique ID)
    $(document).on('click', '#printBarcodeBtn', function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        const sampleCount = parseInt($('#sampleCount').val()) || 1;
        // Get report ID from data attribute or global var if set when opening modal
        const reportId = window.currentBarcodeReportId || 'Unknown';  // Set this when triggering modal
        toastr.info(`Printing ${sampleCount} barcode(s) for report: ${reportId}`);
        $('#barcodeModal').modal('hide');
        // Real print logic here
    });

    // Modal resets and cancels (unique classes)
    $('#assignDoctorModal').on('hidden.bs.modal', function() {
        $('#assignDoctorForm')[0].reset();
        $('#assignTestResultCode').val('');
        $('.modal-assign-submit').prop('disabled', false).html('<i class="mdi mdi-check me-1"></i>Assign');
    });

    $(document).on('click', '.modal-assign-cancel, .modal-barcode-close', function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        $(this).closest('.modal').modal('hide');
    });

    // Prevent any global form submits from interfering
    $('#assignDoctorForm').on('submit', function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        // Do nothing - handled by button click
    });
});
</script>
@endsection
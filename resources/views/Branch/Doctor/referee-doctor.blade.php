@extends('Branch.Layouts.layout')
@section('meta_title') Doctors | ChromoXpert @endsection

@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            {{-- Hero Header with Gradient Background --}}
            <div class="p-4 rounded-4 mb-4 position-relative overflow-hidden shadow-lg"
                 style="background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%); color: #fff;">
                <h2 class="fw-bold mb-1">Referee Doctors</h2>
                <p class="mb-0">Manage all doctor details and commission statuses</p>
                <a href="{{ url('branch/referee-doctors/add') }}" 
                   class="btn btn-light btn-lg mt-3 fw-semibold rounded-pill shadow-sm"
                   style="background: #f6b51d; color: #1f2937; border: none;">
                    <i class="mdi mdi-plus me-2"></i> Add Referee Doctor
                </a>
                <div class="position-absolute top-0 end-0 opacity-25" style="font-size: 120px; color: #ac7fb6;">
                    <i class="mdi mdi-doctor"></i>
                </div>
            </div>

            {{-- Search and Filter Inputs --}}
            <div class="d-flex flex-wrap align-items-center gap-2 mb-4">
                <input type="text" id="searchInput" class="form-control rounded-pill shadow-sm" 
                       placeholder="Search doctors..." aria-label="Search referee doctors"
                       style="max-width: 250px; background: #fff; color: #6267ae; border: 1px solid #f6b51d;padding-top:9px; padding-bottom:9px;">
                <select id="statusFilter" class="form-select rounded-pill shadow-sm" aria-label="Filter by status"
                        style="max-width: 200px; background: #fff; color: #6267ae; border: 1px solid #f6b51d;padding-top:9px; padding-bottom:9px;">
                    <option value="">All Status</option>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
            </div>

            {{-- Glassmorphic Table Card --}}
            <div class="card border-0 shadow-lg rounded-4"
                 style="background: rgba(255,255,255,0.85); backdrop-filter: blur(14px);">
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table id="cims_data_table" class="table align-middle table-hover">
                            <thead style="background: linear-gradient(135deg, #ac7fb6 0%, #f6b51d 100%); color: #fff;">
                                <tr>
                                    <th>Sr No</th>
                                    <th>Code</th>
                                    <th>Doctor Name</th>
                                    <th>Gender</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    {{-- <th>Commission (%)</th> --}}
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Populated by DataTables via AJAX --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
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

    .switch { position: relative; display: inline-block; width: 44px; height: 24px; }
    .switch input { opacity: 0; width: 0; height: 0; }
    .slider {
        position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0;
        background-color: #ccc; transition: .4s; border-radius: 24px;
    }
    .slider:before {
        position: absolute; content: ""; height: 18px; width: 18px; left: 3px; bottom: 3px;
        background-color: white; transition: .4s; border-radius: 50%;
    }
    input:checked + .slider {
        background: linear-gradient(135deg, #6267ae 0%, #f6b51d 100%);
        box-shadow: 0 0 10px #f6b51d;
    }
    input:checked + .slider:before { transform: translateX(20px); }

    .custom-pagination .page-link {
        border-radius: 50%;
        margin: 0 4px; padding: 8px 14px;
        color: #6267ae; font-weight: 600;
        border: none; background: rgba(255,255,255,0.9);
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

    .form-control:focus, .form-select:focus {
        border-color: #f6b51d;
        box-shadow: 0 0 8px rgba(246, 181, 29, 0.5);
    }

    .spinner-border { vertical-align: middle; }

    @media (max-width: 768px) {
        .table-responsive { overflow-x: auto; }
        .table { font-size: 0.9rem; }
        .btn-icon { width: 34px; height: 34px; }
        .form-control, .form-select { font-size: 0.9rem; }
    }
</style>
@endsection

@section('script')
<script src="{{ URL::asset('branch\controller_js\cn_referee-doctor.js') }}"></script>
<script>
    // Debounce function to limit search/filter processing
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Combined search and filter function
    function filterTable() {
        const searchFilter = document.getElementById('searchInput').value.toLowerCase();
        const statusFilter = document.getElementById('statusFilter').value.toLowerCase();
        const rows = document.querySelectorAll('#cims_data_table tbody tr');

        rows.forEach(row => {
            // Get row text for search
            const text = row.innerText.toLowerCase();
            // Get status from toggle switch (handle missing .change-status)
            const statusElement = row.querySelector('.change-status');
            const status = statusElement && statusElement.checked ? 'active' : 'inactive';
            
            // Check if row matches both search and status filters
            const matchesSearch = text.includes(searchFilter);
            const matchesStatus = statusFilter === '' || status === statusFilter;
            row.style.display = matchesSearch && matchesStatus ? '' : 'none';
        });
    }

    // Event listeners for search and filter
    document.getElementById('searchInput').addEventListener('keyup', debounce(filterTable, 300));
    document.getElementById('statusFilter').addEventListener('change', filterTable);

    // Listen for table updates (custom event from cn_referee-doctor.js or DataTables)
    document.addEventListener('tableUpdated', filterTable);

    // Initialize Bootstrap tooltips
    $(function () {
        $('[data-bs-toggle="tooltip"]').tooltip();
    });

    // Ensure filter is applied on page load
    document.addEventListener('DOMContentLoaded', filterTable);

    // If using DataTables, sync with its draw event
    $(document).ready(function() {
        if ($.fn.DataTable && $('#cims_data_table').DataTable()) {
            $('#cims_data_table').on('draw.dt', filterTable);
        }
    });
</script>
@endsection
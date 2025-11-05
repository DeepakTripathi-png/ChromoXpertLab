@extends('Admin.Layouts.layout')
@section('meta_title', 'Pets | ChromoXpert')

@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            {{-- Hero Header with Gradient Background --}}
            <div class="p-4 rounded-4 mb-4 position-relative overflow-hidden shadow-lg"
                 style="background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%); color: #fff;">
                <h2 class="fw-bold mb-1">Pet Management</h2>
                <p class="mb-0">View and manage all registered pets</p>
                <a href="{{ url('admin/pet/add') }}" 
                   class="btn btn-light btn-lg mt-3 fw-semibold rounded-pill shadow-sm"
                   style="background: #f6b51d; color: #1f2937; border: none;">
                    <i class="mdi mdi-plus me-2"></i> Add Pet
                </a>
                <div class="position-absolute top-0 end-0 opacity-25" style="font-size: 120px; color: #ac7fb6;">
                    <i class="mdi mdi-paw"></i>
                </div>
            </div>

            {{-- Search and Filter Inputs --}}
            <div class="d-flex flex-wrap align-items-center gap-2 mb-4">
                <!-- Search Box -->
                <div class="input-group rounded-pill shadow-sm" 
                    style="max-width: 280px; background: #fff; border: 1px solid #f6b51d;">
                    <span class="input-group-text bg-transparent border-0 pe-1">
                        <i class="mdi mdi-magnify" style="color: #6267ae;"></i>
                    </span>
                    <input type="search" id="searchInput" 
                        class="form-control border-0 ps-1 rounded-pill" 
                        placeholder="Search pets..."
                        style="color: #6267ae;">
                </div>

                <!-- Status Filter -->
                <select id="statusFilter" 
                        class="form-select rounded-pill shadow-sm"
                        style="max-width: 200px; background: #fff; color: #6267ae; 
                            border: 1px solid #f6b51d; padding-top:9px; padding-bottom:9px;">
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
                                    <th style="width: 5%;">#</th>
                                    <th style="width: 10%;">Code</th>
                                    <th style="width: 15%;">Pet Parent</th>
                                    <th style="width: 15%;">Name</th>
                                    <th style="width: 10%;">Gender</th>
                                    <th style="width: 10%;">DOB</th>
                                    <th style="width: 10%;">Image</th>
                                    <th style="width: 10%;" class="text-center">Status</th>
                                    <th style="width: 15%;" class="text-center">Actions</th>
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

<!-- Loading Spinner (hidden by default) -->
<div id="loadingSpinner" class="d-none position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center" style="background: rgba(0,0,0,0.1); z-index: 9999;">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
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

    .table > thead th {
        border-bottom: none;
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .table-responsive { overflow-x: auto; }
        .table { font-size: 0.9rem; }
        .btn-icon { width: 34px; height: 34px; }
        .form-control, .form-select { font-size: 0.9rem; }
    }
</style>
@endsection

@section('script')
<script src="{{ URL::asset('admin_panel/controller_js/cn_pet.js') }}"></script>
<script>
    // Reusable config
    const tableSelector = '#cims_data_table';
    const searchInputId = 'searchInput';
    const statusFilterId = 'statusFilter';
    const statusCheckboxClass = '.change-status';

    // Debounce function to limit search input processing
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

    // Combined filter function: Handles both search + status together
    function applyCombinedFilter() {
        const searchFilter = document.getElementById(searchInputId)?.value.toLowerCase() || '';
        const statusFilter = document.getElementById(statusFilterId)?.value.toLowerCase() || '';

        document.querySelectorAll(`${tableSelector} tbody tr`).forEach(function(row) {
            const rowText = row.innerText.toLowerCase();
            const checkbox = row.querySelector(statusCheckboxClass);
            const rowStatus = checkbox ? (checkbox.checked ? 'active' : 'inactive') : '';

            const matchesSearch = !searchFilter || rowText.includes(searchFilter);
            const matchesStatus = !statusFilter || rowStatus === statusFilter;

            row.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
        });
    }

    // Search functionality with debounce (triggers combined filter)
    if (document.getElementById(searchInputId)) {
        document.getElementById(searchInputId).addEventListener('keyup', debounce(function() {
            applyCombinedFilter();
        }, 300));
    }

    // Status filter functionality (triggers combined filter)
    if (document.getElementById(statusFilterId)) {
        document.getElementById(statusFilterId).addEventListener('change', function() {
            applyCombinedFilter();
        });
    }

    // Optional: Initial filter on load
    document.addEventListener('DOMContentLoaded', function() {
        applyCombinedFilter();
    });

    // For dynamic data loading (e.g., from cn_pet.js): Listen for custom event or mutation
    // Assuming cn_pet.js dispatches 'dataLoaded' event after appending rows
    document.addEventListener('dataLoaded', function() {
        applyCombinedFilter();
        // Re-attach event listeners for status changes if needed
        attachStatusListeners();
    });

    // Function to attach status change listeners (for dynamic rows)
    function attachStatusListeners() {
        document.querySelectorAll(`${statusCheckboxClass}:not([data-listener-attached])`).forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const id = this.dataset.id;
                const table = this.dataset.table;
                const flashMessage = this.dataset.flash;

                this.disabled = true;
                // Simulate AJAX (replace with real in cn_pet.js if needed)
                setTimeout(() => {
                    this.disabled = false;
                    // alert(flashMessage); // Use toastr or similar
                    applyCombinedFilter(); // Re-filter after status change
                }, 1000);

                checkbox.dataset.listenerAttached = 'true'; // Prevent duplicate attachments
            });
        });
    }

    // Call attach on load
    document.addEventListener('DOMContentLoaded', attachStatusListeners);

    // Initialize Bootstrap tooltips
    $(function () {
        $('[data-bs-toggle="tooltip"]').tooltip();
    });

    // If cn_pet.js uses jQuery, you can also hook into its AJAX success
    // Example: In cn_pet.js, after appending rows: $(document).trigger('dataLoaded');
</script>
@endsection
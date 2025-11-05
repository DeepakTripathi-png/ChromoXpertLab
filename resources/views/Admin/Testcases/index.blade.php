@extends('Admin.Layouts.layout')
@section('meta_title') Tests | ChromoXpert @endsection

@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            {{-- Hero Header with Gradient Background --}}
            <div class="p-4 rounded-4 mb-4 position-relative overflow-hidden shadow-lg"
                 style="background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%); color: #fff;">
                <h2 class="fw-bold mb-1">Laboratory Tests</h2>
                <p class="mb-0">Manage all laboratory test details and statuses</p>
                <a href="{{ url('admin/test-case/add') }}" 
                   class="btn btn-light btn-lg mt-3 fw-semibold rounded-pill shadow-sm"
                   style="background: #f6b51d; color: #1f2937; border: none;">
                    <i class="mdi mdi-plus me-2"></i> Add Test
                </a>

                  
                <a href="{{ url('admin/test-profile') }}" 
                   class="btn btn-light btn-lg mt-3 fw-semibold rounded-pill shadow-sm"
                   style="background: #f6b51d; color: #1f2937; border: none;">
                      Create Profile <i class="mdi mdi-arrow-right me-2"></i>
                </a>

                <div class="position-absolute top-0 end-0 opacity-25" style="font-size: 120px; color: #ac7fb6;">
                    <i class="mdi mdi-test-tube"></i>
                </div>
            </div>

            {{-- Search and Filter Inputs --}}
            <div class="d-flex flex-wrap align-items-center gap-2 mb-4">
                <div class="input-group rounded-pill shadow-sm" 
                     style="max-width: 280px; background: #fff; border: 1px solid #f6b51d;">
                    <span class="input-group-text bg-transparent border-0 pe-1">
                        <i class="mdi mdi-magnify" style="color: #6267ae;"></i>
                    </span>
                    <input type="text" id="searchInput" class="form-control border-0 ps-1 rounded-pill" 
                           placeholder="Search tests..." style="color: #6267ae;">
                </div>
                <select id="statusFilter" class="form-select rounded-pill shadow-sm" 
                        style="max-width: 200px; background: #fff; color: #6267ae; border: 1px solid #f6b51d; padding-top:9px; padding-bottom:9px;">
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
                                    <th style="width: 10%;">Test Code</th>
                                    <th style="width: 20%;">Test Name</th>
                                    <th style="width: 20%;">Short Name</th>
                                      <th style="width: 20%;">Department Name</th>
                                    <th style="width: 15%;">Sample Type</th>
                                    <th style="width: 10%;">Base Price (₹)</th>
                                    <th style="width: 10%;">GST (%)</th>
                                    <th style="width: 10%;">Total Price (₹)</th>
                                    <th style="width: 15%;">Parameter Count</th>
                                    <th style="width: 10%;" class="text-center">Status</th>
                                    <th style="width: 15%;" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- No Results Message --}}
            <div id="noResultsMessage" class="alert alert-info text-center d-none" 
                 style="background: #6267ae; color: #fff; border: none; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
                No tests found matching your criteria.
            </div>

            {{-- Loading Spinner --}}
            <div id="loadingSpinner" class="d-none position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center" 
                 style="background: rgba(0,0,0,0.1); z-index: 9999;">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
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

    .alert {
        border: none;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    @media (max-width: 768px) {
        .table-responsive { overflow-x: auto; }
        .table { font-size: 0.9rem; }
        .btn-icon { width: 34px; height: 34px; }
        .form-control, .form-select { font-size: 0.9rem; }
    }
</style>
@endsection

@section('scripts')
<script src="{{ URL::asset('admin_panel/controller_js/cn_test.js') }}"></script>
<script>
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

    // Combined search and filter function
    function applyFilters() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const statusFilter = document.getElementById('statusFilter').value.toLowerCase();
        const noResultsMessage = document.getElementById('noResultsMessage');
        let visibleRowCount = 0;

        document.querySelectorAll('#cims_data_table tbody tr').forEach(function(row) {
            const text = row.innerText.toLowerCase();
            const statusElement = row.querySelector('.change-status');
            const status = statusElement ? (statusElement.checked ? 'active' : 'inactive') : 'inactive';
            
            const matchesSearch = text.includes(searchTerm);
            const matchesStatus = statusFilter === '' || status === statusFilter;
            
            if (matchesSearch && matchesStatus) {
                row.style.display = '';
                visibleRowCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Show/hide no results message
        noResultsMessage.classList.toggle('d-none', visibleRowCount > 0);
    }

    // Event listeners for search and filter
    document.getElementById('searchInput').addEventListener('keyup', debounce(applyFilters, 300));
    document.getElementById('statusFilter').addEventListener('change', applyFilters);

    // Re-apply filters when status toggle changes
    document.getElementById('cims_data_table').addEventListener('change', function(event) {
        if (event.target.classList.contains('change-status')) {
            applyFilters();
        }
    });

    // Initialize Bootstrap tooltips
    $(function () {
        $('[data-bs-toggle="tooltip"]').tooltip();
    });

    // Optional: Example of server-side integration (uncomment if needed)
    /*
    function fetchFilteredData() {
        const search = document.getElementById('searchInput').value;
        const status = document.getElementById('statusFilter').value;
        document.getElementById('loadingSpinner').classList.remove('d-none');

        fetch('/admin/test-case/filter', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ search, status })
        })
        .then(response => response.json())
        .then(data => {
            updateTable(data); // Implement this function in cn_test.js to update table rows
            applyFilters(); // Re-apply client-side filters after table update
            document.getElementById('loadingSpinner').classList.add('d-none');
        })
        .catch(error => {
            console.error('Error fetching data:', error);
            document.getElementById('loadingSpinner').classList.add('d-none');
        });
    }
    */
</script>
@endsection
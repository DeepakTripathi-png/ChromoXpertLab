@extends('Admin.Layouts.layout')

@section('meta_title', 'Pet Parent / Care Of | ChromoXpert')

@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">

            {{-- Hero Header --}}
            <div class="p-4 rounded-4 mb-4 position-relative overflow-hidden shadow-lg"
                 style="background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%); color: #fff;">
                <h2 class="fw-bold mb-1">Pet Parent / Care Of</h2>
                <p class="mb-0">Manage pet parent or care of records for ChromoXpert</p>
                <a href="{{ url('admin/parent/add') }}" 
                   class="btn btn-light btn-lg mt-3 fw-semibold rounded-pill shadow-sm"
                   style="background: #f6b51d; color: #1f2937; border: none;">
                    <i class="mdi mdi-plus me-2"></i> Add Pet Parent / Care Of
                </a>
                <div class="position-absolute top-0 end-0 opacity-25" style="font-size: 120px; color: #ac7fb6;">
                    <i class="mdi mdi-account-group"></i>
                </div>
            </div>

            {{-- Search + Filter --}}
            <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                <div class="input-group rounded-pill shadow-sm" style="max-width: 300px; background: #fff; border: 1px solid #f6b51d;">
                    <span class="input-group-text bg-transparent border-0 pe-1">
                        <i class="mdi mdi-magnify" style="color: #6267ae;"></i>
                    </span>
                    <input type="text" id="searchInput" class="form-control border-0 ps-1 rounded-pill" placeholder="Search..." style="color: #6267ae;">
                </div>
                <select id="statusFilter" class="form-select rounded-pill shadow-sm" style="max-width: 200px; background: #fff; color: #6267ae; border: 1px solid #f6b51d;padding-top:9px; padding-bottom:9px;">
                    <option value="">All Status</option>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
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
                                    <th>Sr No</th>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Gender</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Status</th>
                                    <th >Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- <tr class="fade-in-row">
                                    <td>1</td>
                                    <td>USR001</td>
                                    <td>John Doe</td>
                                    <td>9876543210</td>
                                    <td>₹5000.00</td>
                                    <td>₹3000.00</td>
                                    <td>₹2000.00</td>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" class="change-status" 
                                                   data-id="1" data-table="pet_parents" 
                                                   data-flash="Status Changed Successfully!" checked>
                                            <span class="slider"></span>
                                        </label>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ url('admin/pet-parent/edit/1') }}">
                                            <button type="button" class="btn btn-icon btn-warning me-1" title="Edit" style="background: #fff; color: #f6b51d; border: 1px solid #f6b51d;">
                                                <i class="mdi mdi-pencil"></i>
                                            </button>
                                        </a>
                                        <button type="button" class="btn btn-icon btn-danger delete" 
                                                data-id="1" data-table="pet_parents" 
                                                data-flash="Pet Parent Deleted Successfully!" title="Delete" style="background: #fff; color: #cc235e; border: 1px solid #cc235e;">
                                            <i class="mdi mdi-trash-can"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="fade-in-row">
                                    <td>2</td>
                                    <td>USR002</td>
                                    <td>Jane Smith</td>
                                    <td>8765432109</td>
                                    <td>₹7500.00</td>
                                    <td>₹5000.00</td>
                                    <td>₹2500.00</td>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" class="change-status" 
                                                   data-id="2" data-table="pet_parents" 
                                                   data-flash="Status Changed Successfully!">
                                            <span class="slider"></span>
                                        </label>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ url('admin/pet-parent/edit/2') }}">
                                            <button type="button" class="btn btn-icon btn-warning me-1" title="Edit" style="background: #fff; color: #f6b51d; border: 1px solid #f6b51d;">
                                                <i class="mdi mdi-pencil"></i>
                                            </button>
                                        </a>
                                        <button type="button" class="btn btn-icon btn-danger delete" 
                                                data-id="2" data-table="pet_parents" 
                                                data-flash="Pet Parent Deleted Successfully!" title="Delete" style="background: #fff; color: #cc235e; border: 1px solid #cc235e;">
                                            <i class="mdi mdi-trash-can"></i>
                                        </button>
                                    </td>
                                </tr> --}}
                            </tbody>
                        </table>
                    </div>

                    {{-- Custom Pagination --}}
                    {{-- <nav class="mt-3">
                        <ul class="pagination justify-content-center custom-pagination">
                            <li class="page-item disabled"><a class="page-link" href="#">«</a></li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">»</a></li>
                        </ul>
                    </nav> --}}


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

    .switch { 
        position: relative; 
        display: inline-block; 
        width: 44px; 
        height: 24px; 
    }
    .switch input { 
        opacity: 0; 
        width: 0; 
        height: 0; 
    }
    .slider {
        position: absolute; 
        cursor: pointer; 
        top: 0; 
        left: 0; 
        right: 0; 
        bottom: 0;
        background-color: #ccc; 
        transition: .4s; 
        border-radius: 24px;
    }
    .slider:before {
        position: absolute; 
        content: ""; 
        height: 18px; 
        width: 18px; 
        left: 3px; 
        bottom: 3px;
        background-color: white; 
        transition: .4s; 
        border-radius: 50%;
    }
    input:checked + .slider {
        background: linear-gradient(135deg, #6267ae 0%, #f6b51d 100%);
        box-shadow: 0 0 10px #f6b51d;
    }
    input:checked + .slider:before { 
        transform: translateX(20px); 
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

    .btn-light:hover {
        background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%);
        color: #fff !important;
        border-color: transparent;
    }
</style>
@endsection

@section('script')
<script src="{{ URL::asset('admin_panel/controller_js/cn_petparent.js')}}"></script>
<script>
    // Client-side search
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        document.querySelectorAll('#cims_data_table tbody tr').forEach(function(row) {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });

    // Client-side status filter
    document.getElementById('statusFilter').addEventListener('change', function() {
        let filter = this.value.toLowerCase();
        document.querySelectorAll('#cims_data_table tbody tr').forEach(function(row) {
            let status = row.querySelector('.change-status').checked ? 'active' : 'inactive';
            row.style.display = (filter === '' || status === filter) ? '' : 'none';
        });
    });

    // Handle status change
    document.querySelectorAll('.change-status').forEach(function(checkbox) {
        checkbox.addEventListener('click', function() {
            const id = this.dataset.id;
            const table = this.dataset.table;
            const flashMessage = this.dataset.flash;

            // Simulate status change (replace with actual AJAX call in production)
            this.disabled = true;
            setTimeout(() => {
                this.disabled = false;
                alert(flashMessage); // Replace with toastr or similar in production
            }, 1000);
        });
    });

    // Handle delete action
    document.querySelectorAll('.delete').forEach(function(button) {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const table = this.dataset.table;
            const flashMessage = this.dataset.flash;

            // Confirm deletion
            if (confirm('Are you sure you want to delete this pet parent record?')) {
                // Simulate deletion (replace with actual AJAX call in production)
                this.disabled = true;
                const row = this.closest('tr');
                row.style.transition = 'opacity 0.3s';
                row.style.opacity = '0';
                setTimeout(() => {
                    row.remove();
                    alert(flashMessage); // Replace with toastr or similar in production
                }, 300);
            }
        });
    });
</script>
@endsection
@extends('Admin.Layouts.layout')

@section('meta_title', 'Revenue | ChromoXpert')

@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">

            {{-- Hero Header --}}
            <div class="p-4 rounded-4 mb-4 position-relative overflow-hidden shadow-lg"
                 style="background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%); color: #fff;">
                <h2 class="fw-bold mb-1">Revenue</h2>
                <p class="mb-0">View and manage all revenue transactions</p>
                <div class="position-absolute top-0 end-0 opacity-25" style="font-size: 120px; color: #ac7fb6;">
                    <i class="mdi mdi-cash-multiple"></i>
                </div>
            </div>

            {{-- Search + Filter --}}
            <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                <div class="input-group rounded-pill shadow-sm" style="max-width: 300px; background: #fff; border: 1px solid #f6b51d;">
                    <span class="input-group-text bg-transparent border-0 pe-1">
                        <i class="mdi mdi-magnify" style="color: #6267ae;"></i>
                    </span>
                    <input type="search" id="searchInput" class="form-control border-0 ps-1" placeholder="Search revenue..." style="color: #6267ae;">
                </div>
                
                <select id="branchFilter" class="form-select rounded-pill shadow-sm" style="max-width: 200px; background: #fff; color: #6267ae; border: 1px solid #f6b51d;">
                    <option value="">All Branches</option>
                    <option value="Central Diagnostics">Central Diagnostics</option>
                    <option value="Northern Diagnostics">Northern Diagnostics</option>
                    <option value="Southern Diagnostics">Southern Diagnostics</option>
                </select>
            </div>

            {{-- Glassmorphic Table Card --}}
            <div class="card border-0 shadow-lg rounded-4"
                 style="background: rgba(255,255,255,0.85); backdrop-filter: blur(14px);">
                <div class="card-body p-3">
                    <div class="table-responsive">
                        <table id="revenue_data_table" class="table align-middle table-hover">
                            <thead style="background: linear-gradient(135deg, #ac7fb6 0%, #f6b51d 100%); color: #fff;">
                                <tr>
                                    <th class="sorting sorting_asc">#</th>
                                    <th class="sorting">Branch</th>
                                    <th class="sorting">Branch Address</th>
                                    <th class="sorting">Branch Head</th>
                                    <th class="sorting">Amount (₹)</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="fade-in-row">
                                    <td class="sorting_1">1</td>
                                    <td>Central Diagnostics</td>
                                    <td>123 Main St, City</td>
                                    <td>Rahul Sharma</td>
                                    <td><strong style="color: #6267ae;">₹2,500</strong></td>
                                    <td class="text-center">
                                        <a href="{{url('admin/revenu/view')}}" class="btn btn-icon btn-info me-1" title="View" style="background: #fff; color: #6267ae; border: 1px solid #6267ae;">
                                            <i class="mdi mdi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                {{-- Other rows can be added here --}}
                            </tbody>
                        </table>
                    </div>

                    {{-- Custom Pagination --}}
                    <nav class="mt-3">
                        <ul class="pagination justify-content-center custom-pagination">
                            <li class="page-item disabled"><a class="page-link" href="#">«</a></li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">»</a></li>
                        </ul>
                    </nav>
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
    
    .table > thead th {
        border-bottom: none;
        font-weight: 600;
    }
</style>
@endsection

@section('script')
<script src="/admin_panel/controller_js/cn_revenue.js"></script>
<script>
document.getElementById('searchInput').addEventListener('keyup', function() {
    let filter = this.value.toLowerCase();
    document.querySelectorAll('#revenue_data_table tbody tr').forEach(function(row) {
        let text = row.innerText.toLowerCase();
        row.style.display = text.includes(filter) ? '' : 'none';
    });
});

document.getElementById('branchFilter').addEventListener('change', function() {
    let filter = this.value.toLowerCase();
    document.querySelectorAll('#revenue_data_table tbody tr').forEach(function(row) {
        let branch = row.cells[1].innerText.toLowerCase();
        row.style.display = (filter === '' || branch === filter) ? '' : 'none';
    });
});

// Status toggle functionality
$(document).on('click', '.switch input', function() {
    const row = $(this).closest('tr');
    const id = row.find('.btn-danger').data('id');
    const table = row.find('.btn-danger').data('table');
    const flash_message = row.find('.btn-danger').data('flash');
    const _token = $('meta[name="csrf-token"]').attr('content');
    const isChecked = $(this).is(':checked');
    
    $.ajax({
        url: "/admin/change-status",
        type: "POST",
        data: {
            id: id,
            table: table,
            status: isChecked ? 1 : 0,
            _token: _token
        },
        success: function(response) {
            if(response.success) {
                toastr.success(flash_message);
            }
        },
        error: function(xhr) {
            toastr.error('Error changing status');
            $(this).prop('checked', !isChecked);
        }
    });
});

// Delete functionality
$(document).on('click', '.btn-danger', function() {
    if(confirm('Are you sure you want to delete this revenue record?')) {
        var id = $(this).data('id');
        var table = $(this).data('table');
        var flash_message = $(this).data('flash');
        var _token = $('meta[name="csrf-token"]').attr('content');
        
        $.ajax({
            url: "/admin/delete-record",
            type: "POST",
            data: {
                id: id,
                table: table,
                _token: _token
            },
            success: function(response) {
                if(response.success) {
                    toastr.success(flash_message);
                    $('.btn-danger[data-id="'+id+'"]').closest('tr').remove();
                    $('#revenue_data_table tbody tr').each(function(index) {
                        $(this).find('td:first').text(index + 1);
                    });
                }
            },
            error: function(xhr) {
                toastr.error('Error deleting record');
            }
        });
    }
});
</script>
@endsection
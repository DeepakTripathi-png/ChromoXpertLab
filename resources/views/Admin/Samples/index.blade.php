@extends('Admin.Layouts.layout')
@section('meta_title') Sample Collections | ChromoXpert @endsection

@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">

            {{-- Hero Header --}}
            <div class="p-4 rounded-4 mb-4 position-relative overflow-hidden shadow-lg"
                 style="background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%); color: #fff;">
                <h2 class="fw-bold mb-1">Sample Collections</h2>
                <p class="mb-0">Manage and view all sample collections from collection centers, hospitals, or labs to destination labs (including central lab transfers)</p>
                <a href="{{ url('admin/sample-collections/add') }}" 
                   class="btn btn-light btn-lg mt-3 fw-semibold rounded-pill shadow-sm"
                   style="background: #f6b51d; color: #1f2937; border: none;">
                    <i class="mdi mdi-plus me-2"></i> Add Sample Collection
                </a>
                <div class="position-absolute top-0 end-0 opacity-25" style="font-size: 120px; color: #ac7fb6;">
                    <i class="mdi mdi-test-tube"></i>
                </div>
            </div>

            {{-- Search + Filter --}}
            <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                <input type="text" id="searchInput" class="form-control rounded-pill shadow-sm" 
                       placeholder="Search samples..." style="max-width: 250px; background: #fff; color: #6267ae; border: 1px solid #f6b51d;padding-top:9px; padding-bottom:9px;">
                <select id="statusFilter" class="form-select rounded-pill shadow-sm" style="max-width: 200px; background: #fff; color: #6267ae; border: 1px solid #f6b51d;padding-top:9px; padding-bottom:9px;">
                    <option value="">All Status</option>
                    <option value="Pending">Pending</option>
                    <option value="Collected">Collected</option>
                    <option value="In Transit">In Transit</option>
                    <option value="Received in Lab">Received in Lab</option>
                    <option value="Transferred to Central Lab">Transferred to Central Lab</option>
                </select>
            </div>

            {{-- Glassmorphic Table Card --}}
            <div class="card border-0 shadow-lg rounded-4"
                 style="background: rgba(255,255,255,0.85); backdrop-filter: blur(14px);">
                <div class="card-body p-3">
                    <div class="table-responsive">
                        <table class="table align-middle table-hover"  id="cims_data_table">
                            <thead style="background: linear-gradient(135deg, #ac7fb6 0%, #f6b51d 100%); color: #fff;">
                                <tr>
                                    <th>#</th>
                                    <th>Sample Code</th>
                                    <th>Appointment Code</th>
                                    <th>Patient Name</th>
                                    <th>Sample Type</th>
                                    <th>Collection Center/Lab/Hospital</th>
                                    <th>Sent To Lab</th>
                                    <th>Status</th>
                                    <th>Collection Date</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>


                               


                                {{-- Add more static rows as needed --}}
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
        background: #fff;
        border: 1px solid #6267ae;
        color: #6267ae;
    }
    .btn-icon:hover { transform: scale(1.15); }

    .fade-in-row { animation: fadeInUp 0.6s ease-in-out; }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

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

    .badge {
        font-size: 0.75em;
    }
</style>
@endsection

@section('script')
<script src="{{ URL::asset('admin_panel\controller_js\cn_sample.js') }}"></script>

<script>
    // Search functionality
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        document.querySelectorAll('tbody tr').forEach(function(row) {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });

    // Status filter functionality
    document.getElementById('statusFilter').addEventListener('change', function() {
        let filter = this.value.toLowerCase();
        document.querySelectorAll('tbody tr').forEach(function(row) {
            let statusText = row.querySelector('.badge').innerText.toLowerCase();
            row.style.display = (filter === '' || statusText === filter) ? '' : 'none';
        });
    });
</script>
@endsection
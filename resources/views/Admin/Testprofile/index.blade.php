@extends('Admin.Layouts.layout')
@section('meta_title') Test Profiles | ChromoXpert @endsection

@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            {{-- Hero Header with Gradient Background --}}
            <div class="p-4 rounded-4 mb-4 position-relative overflow-hidden shadow-lg"
                 style="background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%); color: #fff;">
                <h2 class="fw-bold mb-1">Test Profiles</h2>
                <p class="mb-0">Manage and create test profiles by grouping tests</p>
                <a href="{{ url('admin/test-case')}}" 
                   class="btn btn-light mt-3 fw-semibold rounded-pill shadow-sm"
                   style="background: #f6b51d; color: #1f2937; border: none; transition: transform 0.2s;">
                    <i class="mdi mdi-arrow-left me-2"></i> Back
                </a>
                <div class="position-absolute top-0 end-0 opacity-25" style="font-size: 120px; color: #ac7fb6;">
                    <i class="mdi mdi-test-tube"></i>
                </div>
            </div>
            
            <div class="row">
                {{-- Form and Test Search Section (Left Side) --}}
                <div class="col-lg-12 mb-4">
                    <div class="card border-0 shadow-lg rounded-4" style="background: rgba(255,255,255,0.95);">
                        <div class="card-body p-4">
                            <h4 class="fw-bold mb-4" style="color: #6267ae; border-bottom: 2px solid #f6b51d; padding-bottom: 12px;">
                                {{ !empty($testProfile) ? "Update Test Profile" : "Create Test Profile" }}
                            </h4>

                            <form action="{{ route('testprofile.store') }}" method="POST" id="profileForm">
                                @csrf
                                <input type="hidden" name="id" value="{{ !empty($testProfile->id) ? $testProfile->id : '' }}">

                                {{-- Profile Basic Information --}}
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control rounded-3" id="profile_name" name="name" 
                                                value="{{ !empty($testProfile->name) ? $testProfile->name : '' }}" required placeholder=" ">
                                            <label for="profile_name" style="color: #6267ae;">Profile Name <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control rounded-3" id="profile_code" name="profile_code" 
                                                value="{{ !empty($testProfile->profile_code) ? $testProfile->profile_code : '' }}" required placeholder=" ">
                                            <label for="profile_code" style="color: #6267ae;">Profile Code <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                </div>

                                {{-- Test Search Section --}}
                                <div class="mb-4 p-3 rounded-3" style="background-color: #f8f9fa; border: 1px dashed #f6b51d;">
                                    <h5 class="mb-3" style="color: #6267ae;">
                                        <i class="mdi mdi-magnify me-2"></i>Add Tests to Profile
                                    </h5>
                                    
                                    <div id="selectedTestsCount" class="alert alert-info py-2 mb-3" style="background-color: #e9ecef; color: #6267ae; border: none;">
                                        <i class="mdi mdi-information-outline me-2"></i>
                                        <span id="countText">0 tests selected</span>
                                    </div>

                                    <div class="form-floating mb-3 position-relative">
                                        <input type="text" id="testSearch" class="form-control rounded-3" 
                                               placeholder="Search Test"
                                               style="background: #fff; color: #6267ae; border: 1px solid #f6b51d;">
                                        <label for="testSearch" style="color: #6267ae;">Search Test by Name or Code</label>
                                        <div class="position-absolute top-50 end-0 translate-middle-y me-3">
                                            <i class="mdi mdi-magnify" style="color: #6267ae;"></i>
                                        </div>

                                        <!-- Suggestions -->
                                        <ul id="testSuggestions" 
                                            class="list-group position-absolute w-100 mt-1 shadow-sm rounded-3"
                                            style="z-index: 1000; display: none; max-height: 200px; overflow-y: auto;">
                                        </ul>
                                    </div>

                                    <div class="mt-3">
                                        <h6 class="mb-3" style="color: #6267ae;">Selected Tests</h6>
                                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3" id="testCards">
                                            @if(!empty($selectedTests) && !empty($testProfile))
                                                @foreach($tests as $test)
                                                    @if(in_array($test->id, $selectedTests))
                                                        <div class="col">
                                                            <div class="card border-0 shadow rounded-3 h-100">
                                                                <div class="card-body">
                                                                    <h6 class="card-title mb-2">{{ $test->name }}</h6>
                                                                    <p class="text-muted small mb-1">Code: {{ $test->test_code ?? '' }}</p>
                                                                    <p class="fw-bold mb-0">₹{{ $test->total_price }}</p>
                                                                    <button class="btn btn-sm btn-danger mt-2 remove-test-btn float-end" title="Remove Test">X</button>
                                                                    <input type="hidden" name="tests[]" value="{{ $test->id }}" data-price="{{ $test->total_price }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
                                        <div id="noTestsMessage" class="alert alert-warning text-center mt-3 d-none" 
                                             style="background-color: #fff3cd; color: #856404; border: none;">
                                            <i class="mdi mdi-alert-circle-outline me-2"></i>
                                            No tests added yet. Use the search above to add tests.
                                        </div>
                                    </div>
                                </div>

                                {{-- Profile Details --}}
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="number" class="form-control rounded-3" id="profile_price" name="profile_price" 
                                                   value="{{ !empty($testProfile->profile_price) ? $testProfile->profile_price : '' }}" required placeholder=" " step="0.01" >
                                            <label for="profile_price" style="color: #6267ae;">Profile Price (₹) <span class="text-danger">*</span></label>
                                        </div>
                                    </div>

                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" 
                                            class="form-control rounded-3" 
                                            id="profile_description" 
                                            name="profile_description" 
                                            value="{{ !empty($testProfile->profile_description) ? $testProfile->profile_description : '' }}" 
                                            required 
                                            placeholder=" ">
                                        <label for="profile_description" style="color: #6267ae;">
                                            Profile Description <span class="text-danger">*</span>
                                        </label>
                                    </div>
                                </div>


                                </div>

                                {{-- Submit Button --}}
                                <div class="text-end mt-4 pt-3" style="border-top: 1px solid #e9ecef;">
                                    <button type="submit" class="btn btn-success rounded-pill px-4"
                                            style="background: #6267ae; color: #fff; border: none; padding: 10px 24px; transition: background 0.2s;">
                                        <i class="mdi mdi-content-save me-2"></i> Save Profile
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Table Section (Right Side) --}}
                <div class="col-lg-12 mb-4">
                    <div class="card border-0 shadow-lg rounded-4"
                         style="background: rgba(255,255,255,0.85); backdrop-filter: blur(14px);">
                        <div class="card-body p-4">
                            <h4 class="fw-bold mb-3" style="color: #6267ae; border-bottom: 2px solid #f6b51d; padding-bottom: 12px;">
                                Existing Test Profiles
                            </h4>
                            
                            <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                                <div class="input-group rounded-pill shadow-sm" 
                                     style="max-width: 280px; background: #fff; border: 1px solid #f6b51d;">
                                    <span class="input-group-text bg-transparent border-0 pe-1">
                                        <i class="mdi mdi-magnify" style="color: #6267ae;"></i>
                                    </span>
                                    <input type="text" id="searchInput" class="form-control border-0 ps-1 rounded-pill" 
                                           placeholder="Search profiles..." style="color: #6267ae;">
                                </div>
                                <select id="statusFilter" class="form-select rounded-pill shadow-sm" 
                                        style="max-width: 200px; background: #fff; color: #6267ae; border: 1px solid #f6b51d; padding-top:9px; padding-bottom:9px;">
                                    <option value="">All Status</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>

                            <div class="table-responsive">
                                <table id="cims_data_table" class="table align-middle table-hover">
                                    <thead style="background: linear-gradient(135deg, #ac7fb6 0%, #f6b51d 100%); color: #fff;">
                                        <tr>
                                            <th style="width: 5%;">#</th>
                                            <th style="width: 25%;">Profile Code</th>
                                            <th style="width: 25%;">Profile Name</th>
                                            <th style="width: 25%;">Description</th>
                                            <th style="width: 30%;">Tests Included</th>
                                            <th style="width: 15%;">Profile Price (₹)</th>
                                            <th style="width: 10%;" class="text-center">Status</th>
                                            <th style="width: 15%;" class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>    
                                </table>
                            </div>

                            {{-- No Results Message --}}
                            <div id="noResultsMessage" class="alert alert-info text-center d-none mt-3" 
                                 style="background: #6267ae; color: #fff; border: none; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
                                <i class="mdi mdi-information-outline me-2"></i>
                                No profiles found matching your criteria.
                            </div>
                        </div>
                    </div>
                </div>
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

    .form-control:focus, .form-select:focus {
        border-color: #f6b51d;
        box-shadow: 0 0 8px rgba(246, 181, 29, 0.5);
    }

    .alert {
        border: none;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    /* Style for bulleted list in table */
    .list-unstyled li {
        line-height: 1.6;
        font-size: 0.95rem;
    }
    .list-unstyled i {
        color: #6267ae;
    }

    /* Style for test search cards */
    .card .card {
        transition: transform 0.2s;
    }
    .card .card:hover {
        transform: translateY(-3px);
    }
    .list-group-item-action:hover {
        background-color: #f6b51d;
        color: #fff;
    }
    .remove-test-btn {
        border-radius: 50%;
        padding: 2px 8px;
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .table-responsive { overflow-x: auto; }
        .table { font-size: 0.9rem; }
        .btn-icon { width: 34px; height: 34px; }
        .form-control, .form-select { font-size: 0.9rem; }
        .list-unstyled li { font-size: 0.85rem; }
        .card .card { font-size: 0.9rem; }
    }
</style>
@endsection

@section('scripts')
<script src="{{ URL::asset('admin_panel/controller_js/cn_test_profile.js')}}"></script>
<script src="{{ asset('assets/libs/inputmask/jquery.inputmask.min.js') }}"></script>
<script src="{{ asset('assets/libs/toastr/toastr.min.js') }}"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    let searchInput = document.getElementById("testSearch");
    let suggestionsBox = document.getElementById("testSuggestions");
    let testCards = document.getElementById("testCards");
    let selectedTestsCount = document.getElementById("selectedTestsCount");
    let countText = document.getElementById("countText");
    let profileForm = document.getElementById("profileForm");
    let profilePriceInput = document.getElementById("profile_price");
    let noTestsMessage = document.getElementById("noTestsMessage");

    // Initialize selectedTests from PHP variable
    let selectedTests = @json($selectedTests ?? []);

    let searchTimeout;

    // Configure toastr to show at bottom right and prevent duplicates
    toastr.options = {
        positionClass: "toast-bottom-right",
        preventDuplicates: true,
        timeOut: 3000
    };

    // Show/hide no tests message based on initial state
    updateNoTestsMessage();

    // Search input event with debouncing
    searchInput.addEventListener("keyup", function () {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            let query = this.value.trim();
            if (query.length < 2) {
                suggestionsBox.style.display = "none";
                return;
            }

            fetch("{{ route('tests.search') }}?q=" + encodeURIComponent(query))
                .then(response => response.json())
                .then(data => {
                    suggestionsBox.innerHTML = "";
                    if (data.length > 0) {
                        data.forEach(test => {
                            let li = document.createElement("li");
                            li.classList.add("list-group-item", "list-group-item-action");
                            li.style.cursor = "pointer";
                            li.textContent = `${test.name} (${test.test_code ?? ''}) - ₹${test.total_price}`;
                            li.dataset.id = test.id;
                            li.dataset.name = test.name;
                            li.dataset.price = test.total_price;

                            li.addEventListener("click", function () {
                                addTestCard(test);
                                searchInput.value = "";
                                suggestionsBox.style.display = "none";
                            });

                            suggestionsBox.appendChild(li);
                        });
                        suggestionsBox.style.display = "block";
                    } else {
                        suggestionsBox.style.display = "none";
                    }
                })
                .catch(error => {
                    console.error('Error fetching tests:', error);
                    suggestionsBox.style.display = "none";
                });
        }, 300);
    });

    // Hide suggestions when clicking outside
    document.addEventListener("click", function (e) {
        if (!searchInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
            suggestionsBox.style.display = "none";
        }
    });

    function addTestCard(test) {
        if (selectedTests.includes(test.id)) {
            toastr.warning('Test already added.');
            return;
        }

        selectedTests.push(test.id);

        let card = document.createElement("div");
        card.classList.add("col");
        let input = document.createElement("input");
        input.type = "hidden";
        input.name = "tests[]";
        input.value = test.id;
        input.dataset.price = test.total_price;

        card.innerHTML = `
            <div class="card border-0 shadow rounded-3 h-100">
                <div class="card-body">
                    <h6 class="card-title mb-2">${test.name}</h6>
                    <p class="text-muted small mb-1">Code: ${test.test_code ?? ''}</p>
                    <p class="fw-bold mb-0">₹${test.total_price}</p>
                    <button class="btn btn-sm btn-danger mt-2 remove-test-btn float-end" title="Remove Test">X</button>
                </div>
            </div>
        `;
        card.appendChild(input); // Append input to card

        testCards.appendChild(card);
        updateTotal(); // Update total after adding
        updateCount();
        updateNoTestsMessage();
    }

    // Use event delegation for remove buttons
    testCards.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-test-btn')) {
            const card = e.target.closest('.col');
            const input = card.querySelector('input[name="tests[]"]');
            const testId = parseInt(input.value);

            card.remove();
            selectedTests = selectedTests.filter(id => id !== testId);
            updateTotal(); // Recalculate total based on remaining tests
            updateCount();
            updateNoTestsMessage();
        }
    });

    function updateCount() {
        const count = selectedTests.length;
        countText.textContent = `${count} test${count !== 1 ? 's' : ''} selected`;
    }

    function updateNoTestsMessage() {
        if (selectedTests.length === 0) {
            noTestsMessage.classList.remove('d-none');
        } else {
            noTestsMessage.classList.add('d-none');
        }
    }

    // Update total function
    function updateTotal() {
        let subtotal = 0;
        
        document.querySelectorAll('input[name="tests[]"]').forEach(function (input) {
            const price = parseFloat(input.dataset.price) || 0;
            subtotal += price;
        });

        // Set the profile price to the subtotal
        profilePriceInput.value = subtotal.toFixed(2);
    }

    // Initialize selected tests count and total on page load
    updateCount();
    updateTotal();
    updateNoTestsMessage();

    // Handle form submission
    profileForm.addEventListener("submit", function (e) {
        let testsInputs = profileForm.querySelectorAll('input[name="tests[]"]');
        if (testsInputs.length === 0) {
            e.preventDefault();
            toastr.error('Please select at least one test.');
        }
    }, { once: true }); // Ensure event listener is added only once

    // Table search and filter
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

        noResultsMessage.classList.toggle('d-none', visibleRowCount > 0);
    }

    document.getElementById('searchInput').addEventListener('keyup', debounce(applyFilters, 300));
    document.getElementById('statusFilter').addEventListener('change', applyFilters);

    document.getElementById('cims_data_table').addEventListener('change', function(event) {
        if (event.target.classList.contains('change-status')) {
            applyFilters();
        }
    });

    // Initialize Bootstrap tooltips
    $(function () {
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
});
</script>
@endsection
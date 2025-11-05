<?php
date_default_timezone_set('Asia/Kolkata');
?>

@extends('Admin.Layouts.layout')
@section('meta_title', 'Add New Registration | ChromoXpert')

@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="p-4 rounded-4 mb-4 position-relative overflow-hidden shadow-lg"
                 style="background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%); color: #fff;">
                <h2 class="fw-bold mb-1">Add New Registration</h2>
                <p class="mb-0">Fill in the details to create a new appointment record</p>
                <a href="{{ url()->previous() }}" 
                   class="btn btn-light btn-lg mt-3 fw-semibold rounded-pill shadow-sm"
                   style="background: #f6b51d; color: #1f2937; border: none;">
                    <i class="mdi mdi-arrow-left me-2"></i> Back
                </a>
                <div class="position-absolute top-0 end-0 opacity-25" style="font-size: 120px; color: #ac7fb6;">
                    <i class="mdi mdi-calendar-check"></i>
                </div>
            </div>

            <div class="card border-0 shadow-lg rounded-4" 
                 style="background: rgba(255,255,255,0.95); backdrop-filter: blur(14px);">
                <div class="card-body p-4">

                    <form action="{{ url('admin/appointments/store') }}" method="POST" enctype="multipart/form-data" id="registrationForm" novalidate>
                        @csrf
                        <div class="row g-4">

                            <div class="col-12">
                                <h5 class="fw-bold mb-3" style="color: #6267ae;">Appointment Details</h5>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select rounded-3 select2" id="lab_id" name="lab_id" 
                                            style="background: #fff; color: #6267ae; border: 1px solid #f6b51d;">
                                        <option value="" {{ old('lab_id') ? '' : 'selected' }} disabled>Select Lab</option>
                                        @if(!empty($branches))
                                            @foreach ($branches as $branch)
                                                <option value="{{ $branch->id }}" {{ old('lab_id') == $branch->id ? 'selected' : '' }}>
                                                    {{ $branch->branch_name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="lab_id" style="color: #6267ae;">Lab*</label>
                                    @error('lab_id')
                                        <span class="text-danger" style="color: #cc235e;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="form-floating flex-grow-1">
                                        <select class="form-select rounded-3 select2" id="referee_doctor_id" name="referee_doctor_id" required
                                                style="background: #fff; color: #6267ae; border: 1px solid #f6b51d;">
                                            <option value="" {{ old('referee_doctor_id') ? '' : 'selected' }} disabled>Select Referee Doctor</option>
                                            @if(!empty($refereeDoctors))
                                                @foreach ($refereeDoctors as $referee)
                                                    <option value="{{ $referee->id }}" {{ old('referee_doctor_id') == $referee->id ? 'selected' : '' }}>
                                                        {{ $referee->doctor_name }} ({{ $referee->code }})
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <label for="referee_doctor_id" style="color: #6267ae;">Referee Doctor*</label>
                                    </div>
                                    <button type="button" class="btn btn-outline-secondary rounded-end" data-bs-toggle="modal" data-bs-target="#addRefereeDoctorModal"
                                            style="border-color: #f6b51d; color: #6267ae;">
                                        <i class="mdi mdi-plus"></i>
                                    </button>
                                </div>
                                @error('referee_doctor_id')
                                    <span class="text-danger" style="color: #cc235e;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control rounded-3" id="appointment_date" 
                                        name="appointment_date" value="{{ old('appointment_date', date('Y-m-d')) }}" required
                                        min="{{ date('Y-m-d') }}"
                                        style="background: #fff; color: #6267ae; border: 1px solid #f6b51d;"
                                        onclick="this.showPicker()">
                                    <label for="appointment_date" style="color: #6267ae;">Appointment Date*</label>
                                    @error('appointment_date')
                                        <span class="text-danger" style="color: #cc235e;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="time" class="form-control rounded-3" id="appointment_time" 
                                        name="appointment_time" value="{{ old('appointment_time', date('H:i')) }}" required
                                        style="background: #fff; color: #6267ae; border: 1px solid #f6b51d;"
                                        onclick="this.showPicker()">
                                    <label for="appointment_time" style="color: #6267ae;">Appointment Time*</label>
                                    @error('appointment_time')
                                        <span class="text-danger" style="color: #cc235e;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 mt-4 d-flex justify-content-between align-items-center">
                                <h5 class="fw-bold mb-0" style="color: #6267ae;">Pet Owner Details</h5>
                                <button type="button" class="btn btn-primary btn-lg rounded-pill shadow-sm px-4" 
                                        style="background: #6267ae; color: #fff; border: none;" 
                                        data-bs-toggle="modal" data-bs-target="#addPetModal">
                                    <i class="mdi mdi-plus me-2"></i> Add Pet/Pet Owner
                                </button>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="tel" class="form-control rounded-3" id="phone" 
                                        name="phone" value="{{ old('phone') }}" placeholder=" " 
                                        pattern="(\+91)?[0-9]{10}"  title="Phone number must start with +91 followed by 10 digits"
                                        style="background: #fff; color: #6267ae; border: 1px solid #f6b51d;">
                                    <label for="phone" style="color: #6267ae;">Phone Number (+91)</label>
                                    @error('phone')
                                        <span class="text-danger" style="color: #cc235e;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control rounded-3" id="pet_owner_name" 
                                        name="pet_owner_name" value="{{ old('pet_owner_name') }}" placeholder=" " 
                                        style="background: #fff; color: #6267ae; border: 1px solid #f6b51d;">
                                    <label for="pet_owner_name" style="color: #6267ae;">Pet Owner Name</label>
                                    @error('pet_owner_name')
                                        <span class="text-danger" style="color: #cc235e;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <h5 class="fw-bold mb-3" style="color: #6267ae;">Pet Details</h5>
                            </div>

                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="form-floating flex-grow-1">
                                        <select class="form-select rounded-3 select2" id="pet_id" name="pet_id" 
                                                style="background: #fff; color: #6267ae; border: 1px solid #f6b51d;">
                                            <option value="" selected disabled>Select Pet</option>
                                            {{-- @if(!empty($pets))
                                                @foreach ($pets as $pet)
                                                    <option value="{{ $pet->id }}">{{ $pet->name }}</option>
                                                @endforeach
                                            @endif --}}
                                            {{-- <option value="new">Add New Pet</option> --}}
                                        </select>
                                        <label for="pet_id" style="color: #6267ae;">Pet</label>
                                    </div>
                                </div>
                                @error('pet_id')
                                    <span class="text-danger" style="color: #cc235e;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control rounded-3" id="pet_code" 
                                        name="pet_code" value="{{ old('pet_code') }}" readonly 
                                        style="background: #f8f9fa; color: #6267ae; border: 1px solid #f6b51d;">
                                    <label for="pet_code" style="color: #6267ae;">Pet Code</label>
                                    @error('pet_code')
                                        <span class="text-danger" style="color: #cc235e;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control rounded-3" id="pet_type" 
                                        name="pet_type" value="{{ old('pet_type') }}" placeholder=" " 
                                        style="background: #fff; color: #6267ae; border: 1px solid #f6b51d;">
                                    <label for="pet_type" style="color: #6267ae;">Pet Type/Breed</label>
                                    @error('pet_type')
                                        <span class="text-danger" style="color: #cc235e;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select rounded-3" id="pet_gender" name="pet_gender" 
                                            style="background: #fff; color: #6267ae; border: 1px solid #f6b51d;">
                                        <option value="" selected disabled>Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Other">Other</option>
                                    </select>
                                    <label for="pet_gender" style="color: #6267ae;">Pet Gender</label>
                                    @error('pet_gender')
                                        <span class="text-danger" style="color: #cc235e;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control rounded-3" id="pet_dob" 
                                        name="pet_dob" value="{{ old('pet_dob') }}" placeholder=" " 
                                        max="{{ date('Y-m-d') }}"
                                        style="background: rgba(255,255,255,0.95); border: 1px solid #f6b51d;">
                                    <label for="pet_dob" style="color: #6267ae;">Pet Date of Birth</label>
                                    @error('pet_dob')
                                        <span class="text-danger small mt-1" style="color: #cc235e;">
                                            <i class="mdi mdi-alert-circle me-1"></i> {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control rounded-3" id="pet_age" 
                                        name="pet_age" value="{{ old('pet_age') }}" placeholder=" " 
                                        style="background: rgba(255,255,255,0.95); border: 1px solid #f6b51d;">
                                    <label for="pet_age" style="color: #6267ae;">Pet Age</label>
                                    @error('pet_age')
                                        <span class="text-danger small mt-1" style="color: #cc235e;">
                                            <i class="mdi mdi-alert-circle me-1"></i> {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control rounded-3" id="notes" name="notes" 
                                              rows="4" placeholder=" " style="background: #fff; color: #6267ae; border: 1px solid #f6b51d;">{{ old('notes') }}</textarea>
                                    <label for="notes" style="color: #6267ae;">Notes</label>
                                    @error('notes')
                                        <span class="text-danger" style="color: #cc235e;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <div class="card border-0 shadow-lg rounded-4 test-search-card" 
                                     style="background: rgba(255,255,255,0.95); backdrop-filter: blur(14px); z-index: 10;">
                                    <div class="card-body p-3">
                                        <div id="selectedTestsCount" class="text-muted mb-3">0 tests selected</div>
                                        
                                        <div class="form-floating mb-3 position-relative">
                                            <input type="text" id="testSearch" class="form-control rounded-3" 
                                                placeholder="Search Test"
                                                style="background: #fff; color: #6267ae; border: 1px solid #f6b51d;">
                                            <label for="testSearch" style="color: #6267ae;">Search Test</label>

                                            <!-- Suggestions -->
                                            <ul id="testSuggestions" 
                                                class="list-group position-absolute w-100 mt-1 shadow-sm"
                                                style="z-index: 1000; display: none;" onclick="hideSuggestions()">
                                            </ul>
                                        </div>

                                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3" id="testCards">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <div class="card border-0 shadow-lg rounded-4" 
                                     style="background: rgba(255,255,255,0.95); backdrop-filter: blur(14px);">
                                    <div class="card-body p-3">
                                        <h5 class="fw-bold mb-3" style="color: #6267ae;">Receipt</h5>
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <div class="form-floating">
                                                    <input type="number" step="0.01" class="form-control rounded-3" id="subtotal" 
                                                        name="subtotal" placeholder="0.00" readonly
                                                        style="background: #fff; color: #6267ae; border: 1px solid #f6b51d;">
                                                    <label for="subtotal" style="color: #6267ae;">Subtotal (₹)</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating">
                                                    <input type="number" step="0.01" min="0" class="form-control rounded-3" id="discount" 
                                                        name="discount" placeholder="0.00"
                                                        style="background: #fff; color: #6267ae; border: 1px solid #f6b51d;">
                                                    <label for="discount" style="color: #6267ae;">Discount (₹)</label>
                                                    @error('discount')
                                                        <span class="text-danger" style="color: #cc235e;">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-floating">
                                                    <input type="number" step="0.01" class="form-control rounded-3" id="total" 
                                                        name="total" placeholder="0.00" readonly
                                                        style="background: #fff; color: #6267ae; border: 1px solid #f6b51d;">
                                                    <label for="total" style="color: #6267ae;">Total (₹)</label>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-floating">
                                                    <input type="number" step="0.01" class="form-control rounded-3" id="paid_amount" 
                                                        name="paid_amount" placeholder="0.00" 
                                                        style="background: #fff; color: #6267ae; border: 1px solid #f6b51d;">
                                                    <label for="paid_amount" style="color: #6267ae;">Paid Amount (₹)</label>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-floating">
                                                    <select class="form-select rounded-3" id="payment_mode" name="payment_mode" 
                                                            style="background: #fff; color: #6267ae; border: 1px solid #f6b51d;">
                                                        <option value="" selected disabled>Select Payment Mode</option>
                                                        <option value="Cash">Cash</option>
                                                        <option value="Card">Card</option>
                                                        <option value="UPI">UPI</option>
                                                        <option value="Bank Transfer">Bank Transfer</option>
                                                    </select>
                                                    <label for="payment_mode" style="color: #6267ae;">Payment Mode*</label>
                                                    @error('payment_mode')
                                                        <span class="text-danger" style="color: #cc235e;">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control rounded-3" id="transaction_id" 
                                                        name="transaction_id" placeholder="Enter Transaction ID"
                                                        style="background: #fff; color: #6267ae; border: 1px solid #f6b51d;">
                                                    <label for="transaction_id" style="color: #6267ae;">Transaction ID</label>
                                                    @error('transaction_id')
                                                        <span class="text-danger" style="color: #cc235e;">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating">
                                                    <select class="form-select rounded-3" id="payment_status" name="payment_status" 
                                                            style="background: #fff; color: #6267ae; border: 1px solid #f6b51d;">
                                                        <option value="" selected disabled>Select Payment Status</option>
                                                        <option value="Pending">Pending</option>
                                                        <option value="Completed">Completed</option>
                                                        <option value="Failed">Failed</option>
                                                    </select>
                                                    <label for="payment_status" style="color: #6267ae;">Payment Status*</label>
                                                    @error('payment_status')
                                                        <span class="text-danger" style="color: #cc235e;">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating">
                                                    <input type="datetime-local" class="form-control rounded-3" id="payment_date" 
                                                        name="payment_date" 
                                                        value="{{ old('payment_date', date('Y-m-d\TH:i')) }}" 
                                                        style="background: #fff; color: #6267ae; border: 1px solid #f6b51d;">
                                                    <label for="payment_date" style="color: #6267ae;">Payment Date & Time</label>
                                                    @error('payment_date')
                                                        <span class="text-danger" style="color: #cc235e;">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <input type="hidden" id="total_amount" name="total_amount" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="mt-4 d-flex gap-2">
                            <button type="submit" class="btn btn-success btn-lg rounded-pill shadow-sm px-4"
                                    style="background: #6267ae; color: #fff; border: none;" id="submitBtn">
                                <span class="spinner-border spinner-border-sm d-none me-1" id="submitSpinner"></span>
                                <i class="mdi mdi-content-save me-2"></i> Add Appointment
                            </button>
                            <button type="reset" class="btn btn-secondary btn-lg rounded-pill shadow-sm px-4"
                                    style="background: #ac7fb6; color: #fff; border: none;">
                                <i class="mdi mdi-refresh me-2"></i> Reset
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Pet/Pet Owner Modal -->
<div class="modal fade" id="addPetModal" tabindex="-1" aria-labelledby="addPetModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0" style="background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%);">
                <h5 class="modal-title text-white" id="addPetModalLabel">Add New Pet and Owner</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="addPetForm" enctype="multipart/form-data">
                    @csrf
                    <h6 class="fw-semibold mb-3" style="color: #6267ae;">Pet Owner Details</h6>
                    <div class="row g-3">
                        <!-- Pet Parent Name -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control rounded-3" id="owner_name" name="owner_name" 
                                       required style="background: rgba(255,255,255,0.95); border: 1px solid #f6b51d;">
                                <label for="owner_name" style="color: #6267ae;">Owner Name*</label>
                                @error('owner_name')
                                    <span class="text-danger small mt-1" style="color: #cc235e;">
                                        <i class="mdi mdi-alert-circle me-1"></i> {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- Pet Parent Email -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="email" class="form-control rounded-3" id="owner_email" name="owner_email" 
                                       required style="background: rgba(255,255,255,0.95); border: 1px solid #f6b51d;">
                                <label for="owner_email" style="color: #6267ae;">Owner Email*</label>
                                @error('owner_email')
                                    <span class="text-danger small mt-1" style="color: #cc235e;">
                                        <i class="mdi mdi-alert-circle me-1"></i> {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- Pet Parent Mobile -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="tel" 
                                    class="form-control rounded-3" id="owner_mobile" name="owner_mobile" pattern="(\+91)?[0-9]{10}" 
                                    title="Phone number must be 10 digits, with or without +91" required 
                                    style="background: rgba(255,255,255,0.95); border: 1px solid #f6b51d;">
                                <label for="owner_mobile" style="color: #6267ae;">Owner Mobile*</label>
                                @error('owner_mobile')
                                    <span class="text-danger small mt-1" style="color: #cc235e;">
                                        <i class="mdi mdi-alert-circle me-1"></i> {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- Pet Parent Address -->
                        <div class="col-12">
                            <div class="form-floating">
                                <textarea class="form-control rounded-3" id="owner_address" name="owner_address" 
                                          placeholder=" " style="height: 100px; background: rgba(255,255,255,0.95); border: 1px solid #f6b51d;"></textarea>
                                <label for="owner_address" style="color: #6267ae;">Owner Address</label>
                                @error('owner_address')
                                    <span class="text-danger small mt-1" style="color: #cc235e;">
                                        <i class="mdi mdi-alert-circle me-1"></i> {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <h6 class="fw-semibold mt-4 mb-3" style="color: #6267ae;">Pet Details</h6>
                    <div class="row g-3">
                        <!-- Pet Name -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control rounded-3" id="pet_name" name="pet_name" 
                                       required style="background: rgba(255,255,255,0.95); border: 1px solid #f6b51d;">
                                <label for="pet_name" style="color: #6267ae;">Pet Name*</label>
                                @error('pet_name')
                                    <span class="text-danger small mt-1" style="color: #cc235e;">
                                        <i class="mdi mdi-alert-circle me-1"></i> {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- Pet Species -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select rounded-3" id="pet_species" name="pet_species" required
                                        style="background: rgba(255,255,255,0.95); border: 1px solid #f6b51d;">
                                    <option value="" selected disabled>Select Species</option>
                                    <option value="Canine">Canine</option>
                                    <option value="Feline">Feline</option>
                                    <option value="Avian">Avian</option>
                                    <option value="Other">Other</option>
                                </select>
                                <label for="pet_species" style="color: #6267ae;">Species*</label>
                                @error('pet_species')
                                    <span class="text-danger small mt-1" style="color: #cc235e;">
                                        <i class="mdi mdi-alert-circle me-1"></i> {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- Pet Breed -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control rounded-3" id="pet_breed" name="pet_breed" 
                                       list="breedOptions" style="background: rgba(255,255,255,0.95); border: 1px solid #f6b51d;">
                                <datalist id="breedOptions"></datalist>
                                <label for="pet_breed" style="color: #6267ae;">Breed</label>
                                @error('pet_breed')
                                    <span class="text-danger small mt-1" style="color: #cc235e;">
                                        <i class="mdi mdi-alert-circle me-1"></i> {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- Pet Type -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select rounded-3" id="pet_type" name="pet_type" required
                                        style="background: rgba(255,255,255,0.95); border: 1px solid #f6b51d;">
                                    <option value="" selected disabled>Select Type</option>
                                    <option value="Dog">Dog</option>
                                    <option value="Cat">Cat</option>
                                    <option value="Bird">Bird</option>
                                    <option value="Other">Other</option>
                                </select>
                                <label for="pet_type" style="color: #6267ae;">Pet Type*</label>
                                @error('pet_type')
                                    <span class="text-danger small mt-1" style="color: #cc235e;">
                                        <i class="mdi mdi-alert-circle me-1"></i> {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- Pet Gender -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select rounded-3" id="pet_gender" name="pet_gender" required
                                        style="background: rgba(255,255,255,0.95); border: 1px solid #f6b51d;">
                                    <option value="" selected disabled>Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                                <label for="pet_gender" style="color: #6267ae;">Pet Gender*</label>
                                @error('pet_gender')
                                    <span class="text-danger small mt-1" style="color: #cc235e;">
                                        <i class="mdi mdi-alert-circle me-1"></i> {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- Pet DOB -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="date" class="form-control rounded-3" id="pet_dob" name="pet_dob" 
                                       max="{{ date('Y-m-d') }}" style="background: rgba(255,255,255,0.95); border: 1px solid #f6b51d;">
                                <label for="pet_dob" style="color: #6267ae;">Pet Date of Birth</label>
                                @error('pet_dob')
                                    <span class="text-danger small mt-1" style="color: #cc235e;">
                                        <i class="mdi mdi-alert-circle me-1"></i> {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- Pet Age -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control rounded-3" id="pet_age" name="pet_age" 
                                       style="background: rgba(255,255,255,0.95); border: 1px solid #f6b51d;">
                                <label for="pet_age" style="color: #6267ae;">Pet Age</label>
                                @error('pet_age')
                                    <span class="text-danger small mt-1" style="color: #cc235e;">
                                        <i class="mdi mdi-alert-circle me-1"></i> {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- Pet Weight -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="number" step="0.1" min="0" class="form-control rounded-3" id="pet_weight" name="pet_weight" 
                                       style="background: rgba(255,255,255,0.95); border: 1px solid #f6b51d;">
                                <label for="pet_weight" style="color: #6267ae;">Pet Weight (kg)</label>
                                @error('pet_weight')
                                    <span class="text-danger small mt-1" style="color: #cc235e;">
                                        <i class="mdi mdi-alert-circle me-1"></i> {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal"
                        style="background: #ac7fb6; color: #fff; border: none;">
                    <i class="mdi mdi-close me-2"></i> Cancel
                </button>
                <button type="button" class="btn btn-primary rounded-pill px-4" id="savePet"
                        style="background: #6267ae; color: #fff; border: none;">
                    <span class="spinner-border spinner-border-sm d-none me-1" id="petSpinner"></span>
                    <i class="mdi mdi-content-save me-2"></i> Save
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Add Referee Doctor Modal -->
<div class="modal fade" id="addRefereeDoctorModal" tabindex="-1" aria-labelledby="addRefereeDoctorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0" style="background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%);">
                <h5 class="modal-title text-white" id="addRefereeDoctorModalLabel">Add New Referee Doctor</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="addRefereeDoctorForm">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="text" class="form-control rounded-3" id="doctor_name" name="doctor_name" 
                                       style="background: rgba(255,255,255,0.95); border: 1px solid #f6b51d;">
                                <label for="doctor_name" style="color: #6267ae;">Doctor Name*</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <select class="form-select rounded-3" id="gender" name="gender" 
                                        style="background: rgba(255,255,255,0.95); border: 1px solid #f6b51d;">
                                    <option value="" selected disabled>Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                                <label for="gender" style="color: #6267ae;">Gender*</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="email" class="form-control rounded-3" id="doctor_email" name="email" 
                                       style="background: rgba(255,255,255,0.95); border: 1px solid #f6b51d;">
                                <label for="doctor_email" style="color: #6267ae;">Email*</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="tel" class="form-control rounded-3" id="doctor_mobile" name="mobile" 
                                       pattern="(\+91)?[0-9]{10}"  title="Phone number must start with +91 followed by 10 digits"
                                       style="background: rgba(255,255,255,0.95); border: 1px solid #f6b51d;">
                                <label for="doctor_mobile" style="color: #6267ae;">Mobile* (+91)</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <textarea class="form-control rounded-3" id="doctor_address" name="address"
                                          style="background: rgba(255,255,255,0.95); border: 1px solid #f6b51d; height: 100px;"></textarea>
                                <label for="doctor_address" style="color: #6267ae;">Address</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal"
                        style="background: #ac7fb6; color: #fff; border: none;">Cancel</button>
                <button type="button" class="btn btn-primary rounded-pill px-4" id="saveRefereeDoctor"
                        style="background: #6267ae; color: #fff; border: none;">
                    <span class="spinner-border spinner-border-sm d-none me-1" id="refDoctorSpinner"></span>
                    Save
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('style')
<style>
    .form-floating>.form-control, 
    .form-floating>.form-select {
        height: calc(3.5rem + 2px);
        padding: 1rem 0.75rem;
    }
    .form-control:focus, .form-select:focus {
        border-color: #f6b51d;
        box-shadow: 0 0 8px rgba(246, 181, 29, 0.5);
    }
    .spinner-border {
        vertical-align: middle;
    }
    .dropify-wrapper {
        border-radius: 1rem !important;
        border: 1px solid #f6b51d !important;
        background: #fff !important;
    }
    .dropify-wrapper .dropify-message p {
        color: #6267ae !important;
    }
    @media (max-width: 768px) {
        .btn-lg {
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
        }
        .form-floating label {
            font-size: 0.9rem;
        }
        .input-group#testSearchGroup {
            max-width: 100%;
        }
    }
    .input-group .form-floating {
        flex: 1;
    }
    .input-group .btn {
        z-index: 2;
        height: calc(3.5rem + 2px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 1rem;
    }
    .modal {
        z-index: 1100 !important;
    }
    .modal-backdrop {
        z-index: 1050 !important;
        backdrop-filter: blur(5px);
        background: rgba(0, 0, 0, 0.5);
    }
    .modal-content {
        background: #ffffff !important;
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
    }
    .modal-header {
        padding: 1.5rem;
        border-bottom: none;
        border-radius: 12px 12px 0 0 !important;
        background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%);
    }
    .modal-body {
        padding: 1.5rem;
    }
    .modal-footer {
        padding: 1rem;
        border-top: none;
        border-radius: 0 0 12px 12px !important;
    }
    .btn-close-white {
        filter: brightness(10);
    }
    .toast {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1150;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: none;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    }
    .toast-header {
        background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%);
        color: white;
        border: none;
    }
    .select2-container--default .select2-selection--single {
        border: 1px solid #f6b51d;
        border-radius: 0.375rem;
        background: #fff;
        height: calc(3.5rem + 2px) !important;
        display: flex;
        align-items: center;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #6267ae;
        line-height: calc(3.5rem - 2px);
        padding-left: 1rem;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: calc(3.5rem - 2px);
        right: 0.5rem;
    }
    .select2-container--default .select2-selection--single:focus {
        border-color: #f6b51d;
        box-shadow: 0 0 8px rgba(246, 181, 29, 0.5);
    }
    .select2-dropdown {
        border: 1px solid #f6b51d;
        border-radius: 0.375rem;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
    }
    .select2-container--default .select2-search--dropdown .select2-search__field {
        border: 1px solid #f6b51d !important;
        border-radius: 0.375rem !important;
        background: rgba(255, 255, 255, 0.95) !important;
        color: #6267ae !important;
        padding: 0.5rem !important;
    }
    .select2-container--default .select2-search--dropdown .select2-search__field:focus {
        border-color: #f6b51d !important;
        box-shadow: 0 0 8px rgba(246, 181, 29, 0.5) !important;
    }
    .select2-container--default .select2-search--dropdown .select2-search__field::placeholder {
        color: #6267ae !important;
        opacity: 0.7 !important;
    }
    .select2-results__option {
        color: #6267ae;
    }
    .select2-results__option--highlighted {
        background: #f6b51d !important;
        color: #1f2937 !important;
    }
    .form-floating .select2-container {
        position: relative;
        z-index: 3;
    }
    .form-floating .select2-container--default .select2-selection--single .select2-selection__rendered {
        margin-top: -0.5rem;
    }
    .test-search-card {
        z-index: 10 !important;
    }
    #testSuggestions {
        z-index: 1000 !important;
    }
    #testCards .card {
        transition: transform 0.2s, box-shadow 0.2s;
        position: relative;
    }
    #testCards .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(98, 103, 174, 0.2);
    }
    #testCards .card .form-check-input:checked + .form-check-label {
        color: #cc235e;
        font-weight: bold;
    }
    #testSearchInput:focus {
        border-color: #f6b51d;
        box-shadow: 0 0 8px rgba(246, 181, 29, 0.5);
    }
    #testSearchInput::placeholder {
        color: #6267ae;
        opacity: 0.7;
    }
    #clearSearch:hover {
        background: #cc235e;
        color: #fff;
    }
    .remove-test-btn {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        background: #cc235e;
        color: #fff;
        border: none;
        border-radius: 50%;
        width: 25px;
        height: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.875rem;
        z-index: 1;
        transition: background 0.2s;
    }
    .remove-test-btn:hover {
        background: #a81c47;
    }
</style>
@endsection

@section('scripts')
<script src="{{ asset('assets/libs/inputmask/jquery.inputmask.min.js') }}"></script>
<script src="{{ asset('assets/libs/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/libs/dropify/js/dropify.min.js') }}"></script>

<script>
$(document).ready(function () {
    // Initialize Dropify
    $('#pet_image').dropify({
        messages: {
            'default': 'Drag and drop an image here or click',
            'replace': 'Drag and drop or click to replace',
            'remove': 'Remove',
            'error': 'Oops, something went wrong.'
        }
    });

    // Update total function
    function updateTotal() {
        let subtotal = 0;
        $('input[name="tests[]"]').each(function () {
            const price = parseFloat($(this).data('price')) || 0;
            subtotal += price;
        });

        let discount = parseFloat($('#discount').val()) || 0;

        if (discount > subtotal) {
            discount = subtotal;
            $('#discount').val(discount.toFixed(2));
            toastr.warning('Discount cannot exceed subtotal.');
        }

        let total = Math.max(0, subtotal - discount);

        $('#subtotal').val(subtotal.toFixed(2));
        $('#total_amount').val(total.toFixed(2));
        $('#total').val(total.toFixed(2));
        // Pre-fill paid_amount with total value
        $('#paid_amount').val(total.toFixed(2));

        const selectedCount = $('input[name="tests[]"]').length;
        $('#selectedTestsCount').text(`${selectedCount} test${selectedCount !== 1 ? 's' : ''} selected`);
    }

    // Event listener for discount input
    $('#discount').on('input', function () {
        updateTotal();
    });

    // Event listener for paid_amount to prevent exceeding total
    $('#paid_amount').on('input', function () {
        const paidAmount = parseFloat($(this).val()) || 0;
        const total = parseFloat($('#total').val()) || 0;
        if (paidAmount > total) {
            $(this).val(total.toFixed(2));
            toastr.warning('Paid amount cannot exceed total amount.');
        }
    });

    // Form validation
    $('#registrationForm').on('submit', function (e) {
        if ($('input[name="tests[]"]').length === 0) {
            e.preventDefault();
            toastr.error('Please select at least one test.');
            return false;
        }

        $('#submitSpinner').removeClass('d-none');
        $('#submitBtn').prop('disabled', true);
    });

    // Breed data for species
    const breedData = {
        'Canine': ['Labrador Retriever', 'German Shepherd', 'Golden Retriever', 'Bulldog', 'Beagle', 
                  'Poodle', 'Rottweiler', 'Yorkshire Terrier', 'Boxer', 'Dachshund'],
        'Feline': ['Persian', 'Maine Coon', 'Siamese', 'Ragdoll', 'Bengal', 
                  'British Shorthair', 'Abyssinian', 'Scottish Fold', 'Sphynx', 'Birman'],
        'Avian': ['Parakeet', 'Cockatiel', 'Lovebird', 'Canary', 'Finch', 
                 'African Grey', 'Macaw', 'Cockatoo', 'Amazon Parrot', 'Conure'],
        'Other': ['Rabbit', 'Hamster', 'Guinea Pig', 'Ferret', 'Turtle', 
                 'Snake', 'Lizard', 'Hedgehog', 'Chinchilla', 'Rat']
    };

    // Update breed options when species changes
    $('#pet_species').on('change', function() {
        const species = $(this).val();
        const breedOptions = $('#breedOptions');
        breedOptions.empty();
        if (species && breedData[species]) {
            breedData[species].forEach(breed => {
                breedOptions.append(`<option value="${breed}">`);
            });
        }
    });

    // Initialize DOB and Age handling for a given DOB and Age input pair
    function initializeAgeHandling(dobSelector, ageSelector) {
        const $dobInput = $(dobSelector);
        const $ageInput = $(ageSelector);

        // Handle DOB change
        $dobInput.on('change', function() {
            const dobVal = $(this).val();
            if (dobVal) {
                const dob = new Date(dobVal);
                if (!isNaN(dob.getTime())) {
                    const age = calculateAgeFromDOB(dob);
                    const ageStr = formatAgeString(age.years, age.months, age.days);
                    $ageInput.val(ageStr).prop('readonly', true).css('background', '#f8f9fa');
                } else {
                    $ageInput.val('').prop('readonly', false).css('background', 'rgba(255,255,255,0.95)');
                }
            } else {
                $ageInput.val('').prop('readonly', false).css('background', 'rgba(255,255,255,0.95)');
            }
        });

        // Handle Age input
        $ageInput.on('blur', function() {
            if (!$(this).prop('readonly')) {
                const ageStr = $(this).val();
                if (ageStr.trim() === '') {
                    $dobInput.val('');
                    return;
                }
                const age = parseAgeInput(ageStr);
                if (age.years === 0 && age.months === 0 && age.days === 0) {
                    toastr.error('Please enter age in format like "1 year 2 months 10 days" or "10 days" etc.');
                    return;
                }
                const dob = calculateDOBFromAge(age.years, age.months, age.days);
                const yyyy = dob.getFullYear();
                const mm = ('0' + (dob.getMonth() + 1)).slice(-2);
                const dd = ('0' + dob.getDate()).slice(-2);
                $dobInput.val(`${yyyy}-${mm}-${dd}`);
                const formattedAge = formatAgeString(age.years, age.months, age.days);
                $ageInput.val(formattedAge).prop('readonly', true).css('background', '#f8f9fa');
            }
        });

        // Allow editing age by clicking if readonly
        $ageInput.on('click', function() {
            if ($(this).prop('readonly')) {
                $(this).prop('readonly', false).css('background', 'rgba(255,255,255,0.95)').val('');
                $dobInput.val('');
            }
        });
    }

    // Initialize for modal
    initializeAgeHandling('#addPetModal #pet_dob', '#addPetModal #pet_age');

    // Initialize for main form
    initializeAgeHandling('#pet_dob', '#pet_age');

    // Parse age input (e.g., "1 year 2 months 10 days")
    function parseAgeInput(ageStr) {
        ageStr = ageStr.toLowerCase().trim();
        const regex = /(\d+)\s*(year|yr|y|month|mon|m|day|d)/g;
        let years = 0, months = 0, days = 0;
        let match;
        while ((match = regex.exec(ageStr)) !== null) {
            const val = parseInt(match[1], 10);
            const unit = match[2];
            if (['year', 'yr', 'y'].includes(unit)) years = val;
            else if (['month', 'mon', 'm'].includes(unit)) months = val;
            else if (['day', 'd'].includes(unit)) days = val;
        }
        return { years, months, days };
    }

    // Format age string
    function formatAgeString(years, months, days) {
        let parts = [];
        if (years > 0) parts.push(years + ' year' + (years > 1 ? 's' : ''));
        if (months > 0) parts.push(months + ' month' + (months > 1 ? 's' : ''));
        if (days > 0) parts.push(days + ' day' + (days > 1 ? 's' : ''));
        if (parts.length === 0) parts.push('0 days');
        return parts.join(' ');
    }

    // Calculate age from DOB
    function calculateAgeFromDOB(dob) {
        const today = new Date();
        let ageYears = today.getFullYear() - dob.getFullYear();
        let ageMonths = today.getMonth() - dob.getMonth();
        let ageDays = today.getDate() - dob.getDate();
        if (ageDays < 0) {
            ageMonths--;
            const lastMonth = new Date(today.getFullYear(), today.getMonth(), 0);
            ageDays += lastMonth.getDate();
        }
        if (ageMonths < 0) {
            ageYears--;
            ageMonths += 12;
        }
        return { years: ageYears, months: ageMonths, days: ageDays };
    }

    // Calculate DOB from age
    function calculateDOBFromAge(years, months, days) {
        const today = new Date();
        let dob = new Date(today.getFullYear() - years, today.getMonth() - months, today.getDate() - days);
        if (dob.getMonth() > today.getMonth()) {
            dob.setFullYear(dob.getFullYear() - 1);
        }
        return dob;
    }

    // Weight validation
    $('#pet_weight').on('input', function() {
        const value = parseFloat($(this).val());
        if (value < 0) {
            $(this).val('');
            toastr.error('Weight cannot be negative.');
        }
    });

    // Add referee doctor functionality
    $('#saveRefereeDoctor').on('click', function () {
        let $btn = $(this);
        let $spinner = $('#refDoctorSpinner');
        let $form = $('#addRefereeDoctorForm');

        if (!$form[0].checkValidity()) {
            $form[0].reportValidity();
            return;
        }

        $spinner.removeClass('d-none');
        $btn.prop('disabled', true);

        $.ajax({
            url: '{{ route("refereedoctor.store-ajax") }}',
            method: 'POST',
            data: $form.serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    let newOption = new Option(
                        `${response.doctor.doctor_name} (${response.doctor.code})`,
                        response.doctor.id,
                        true,
                        true
                    );
                    $('#referee_doctor_id').append(newOption).trigger('change');
                    $('#addRefereeDoctorModal').modal('hide');
                    toastr.success(response.message);
                }
            },
            error: function (xhr) {
                let errors = xhr.responseJSON.errors;
                let errorMessage = 'An error occurred while adding the doctor.';
                if (errors) {
                    errorMessage = Object.values(errors).flat().join('<br>');
                }
                toastr.error(errorMessage);
            },
            complete: function () {
                $spinner.addClass('d-none');
                $btn.prop('disabled', false);
            }
        });

        
    });

    $('#addRefereeDoctorModal').on('hidden.bs.modal', function () {
        $('#addRefereeDoctorForm')[0].reset();
        $('#doctor_mobile').inputmask('+919999999999'); 
    });

    // Add pet functionality
    $('#savePet').on('click', function () {
        let $btn = $(this);
        let $spinner = $('#petSpinner');
        let $form = $('#addPetForm');

        if (!$form[0].checkValidity()) {
            $form[0].reportValidity();
            return;
        }

        const formData = new FormData($form[0]);
        $spinner.removeClass('d-none');
        $btn.prop('disabled', true);

        $.ajax({
            url: '{{ route("pet-and-parent.store") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    let newOption = new Option(response.pet.name, response.pet.id, true, true);
                    $('#pet_id').append(newOption).trigger('change');
                    $('#pet_code').val(response.pet.pet_code);
                    $('#pet_type').val(response.pet.type);
                    $('#pet_gender').val(response.pet.gender);
                    $('#pet_dob').val(response.pet.dob);
                    $('#pet_owner_name').val(response.pet_parent.name);
                    $('#phone').val(response.pet_parent.mobile);
                    $('#addPetModal').modal('hide');
                    toastr.success(response.message);
                }
            },
            error: function (xhr) {
                let errors = xhr.responseJSON.errors;
                let errorMessage = 'An error occurred while adding the pet and owner.';
                if (errors) {
                    errorMessage = Object.values(errors).flat().join('<br>');
                    Object.keys(errors).forEach(field => {
                        $(`#${field}`).next('.text-danger').removeClass('d-none').text(errors[field][0]);
                    });
                }
                toastr.error(errorMessage);
            },
            complete: function () {
                $spinner.addClass('d-none');
                $btn.prop('disabled', false);
            }
        });
    });

    $('#addPetModal').on('hidden.bs.modal', function () {
        $('#addPetForm')[0].reset();
        $('#pet_image').dropify('reset');
        $('.text-danger').addClass('d-none');
    });

    // Handle pet selection
    $('#pet_id').on('change', function () {
        const petId = $(this).val();
        if (petId === 'new') {
            $('#addPetModal').modal('show');
        } else if (petId) {
            $.ajax({
                url: '{{ route("get.pet.details", ":pet_id") }}'.replace(':pet_id', petId),
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    console.log(data);
                    $('#pet_code').val(data.pet_code);
                    $('#pet_type').val(data.type || data.pet_type);
                    $('#pet_gender').val(data.gender || data.pet_gender);
                    $('#pet_dob').val(data.dob || data.pet_dob);
                    $('#pet_owner_name').val(data.owner_name);
                    $('#phone').val(data.owner_phone || data.phone);
                    $('#pet_age').val(data.age || data.pet_age);
                },
                error: function () {
                    toastr.error('Error fetching pet details.');
                    $('#pet_code').val('');
                    $('#pet_type').val('');
                    $('#pet_gender').val('');
                    $('#pet_dob').val('');
                    $('#pet_owner_name').val('');
                    $('#phone').val('');
                    $('#pet_age').val();
                }
            });
        } else {
            $('#pet_code').val('');
            $('#pet_type').val('');
            $('#pet_gender').val('');
            $('#pet_dob').val('');
            $('#pet_owner_name').val('');
            $('#phone').val('');
            $('#pet_age').val();
        }
    });

    let phoneCheckTimeout;
    $('#phone').on('input', function () {
        clearTimeout(phoneCheckTimeout);
        phoneCheckTimeout = setTimeout(() => {
            let phone = $(this).val().trim();
            const phoneRegex = /^(\+91)?[0-9]{10}$/;

            if (!phoneRegex.test(phone)) {
                $('#pet_id').html('<option value="" selected disabled>Select Pet</option><option value="new">Add New Pet</option>');
                $('#pet_owner_name').val('');
                $('#pet_code').val('');
                $('#pet_type').val('');
                $('#pet_gender').val('');
                $('#pet_dob').val('');
                return;
            }

            // Normalize phone to always send without '+91'
            if (phone.startsWith('+91')) {
                phone = phone.slice(3);
            }

            $.ajax({
                url: '{{ route("get.owner.pets.by.phone", ":phone") }}'.replace(':phone', phone),
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.success) {
                        $('#pet_owner_name').val(response.owner.name);
                        const $petSelect = $('#pet_id');
                        $petSelect.html('<option value="" selected disabled>Select Pet</option>');
                        if (response.pets && response.pets.length > 0) {
                            response.pets.forEach(pet => {
                                $petSelect.append(new Option(pet.name, pet.id));
                            });
                        }
                        $petSelect.append(new Option('Add New Pet', 'new'));
                        $('#pet_code').val('');
                        $('#pet_type').val('');
                        $('#pet_gender').val('');
                        $('#pet_dob').val('');
                    } else {
                        toastr.warning(response.message || 'No owner found with this phone number.');
                        $('#pet_owner_name').val('');
                        $('#pet_id').html('<option value="" selected disabled>Select Pet</option><option value="new">Add New Pet</option>');
                        $('#pet_code').val('');
                        $('#pet_type').val('');
                        $('#pet_gender').val('');
                        $('#pet_dob').val('');
                    }
                },
                error: function (xhr) {
                    toastr.error('Error fetching owner details.');
                    $('#pet_owner_name').val('');
                    $('#pet_id').html('<option value="" selected disabled>Select Pet</option><option value="new">Add New Pet</option>');
                    $('#pet_code').val('');
                    $('#pet_type').val('');
                    $('#pet_gender').val('');
                    $('#pet_dob').val('');
                }
            });
        }, 500);
    });

    // Initialize total calculation
    updateTotal();
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    let searchInput = document.getElementById("testSearch");
    let suggestionsBox = document.getElementById("testSuggestions");
    let testCards = document.getElementById("testCards");
    let selectedTestsCount = document.getElementById("selectedTestsCount");

    let selectedTests = [];
    let searchTimeout;

    // Set minimum date for appointment_date to today (client-side for accuracy)
    const today = new Date();
    const yyyy = today.getFullYear();
    const mm = ('0' + (today.getMonth() + 1)).slice(-2);
    const dd = ('0' + today.getDate()).slice(-2);
    const todayStr = `${yyyy}-${mm}-${dd}`;
    const appointmentDateInput = document.getElementById("appointment_date");
    appointmentDateInput.setAttribute("min", todayStr);

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
                            li.textContent = `${test.name} (${test.test_code ?? ''}) - ₹${test.base_price}`;
                            li.dataset.id = test.id;
                            li.dataset.name = test.name;
                            li.dataset.price = test.base_price;

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
        card.innerHTML = `
            <div class="card border-0 shadow rounded-3 h-100">
                <div class="card-body">
                    <h6 class="card-title mb-2">${test.name}</h6>
                    <p class="text-muted small mb-1">Code: ${test.test_code ?? ''}</p>
                    <p class="fw-bold mb-0">₹${test.base_price}</p>
                    <input type="hidden" name="tests[]" value="${test.id}" data-price="${test.base_price}">
                    <button class="btn btn-sm btn-danger mt-2 remove-test-btn float-end" title="Remove Test">X</button>
                </div>
            </div>
        `;

        card.querySelector(".remove-test-btn").addEventListener("click", function () {
            card.remove();
            selectedTests = selectedTests.filter(id => id !== test.id);
            updateCount();
            updateTotal();
        });

        testCards.appendChild(card);
        updateCount();
        updateTotal();
    }

    function updateCount() {
        selectedTestsCount.textContent = `${selectedTests.length} test${selectedTests.length !== 1 ? 's' : ''} selected`;
    }

    // Update total function
    function updateTotal() {
        let subtotal = 0;
        
        $('input[name="tests[]"]').each(function () {
            const price = parseFloat($(this).data('price')) || 0;
            subtotal += price;
        });

        let discount = parseFloat($('#discount').val()) || 0;

        if (discount > subtotal) {
            discount = subtotal;
            $('#discount').val(discount.toFixed(2));
            toastr.warning('Discount cannot exceed subtotal.');
        }

        let total = Math.max(0, subtotal - discount);

        $('#subtotal').val(subtotal.toFixed(2));
        $('#total_amount').val(total.toFixed(2));
        $('#total').val(total.toFixed(2));
        // Pre-fill paid_amount with total value
        $('#paid_amount').val(total.toFixed(2));

        const selectedCount = $('input[name="tests[]"]').length;
        $('#selectedTestsCount').text(`${selectedCount} test${selectedCount !== 1 ? 's' : ''} selected`);
    }
});
</script>

@endsection
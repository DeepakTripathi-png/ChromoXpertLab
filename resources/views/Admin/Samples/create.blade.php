@extends('Admin.Layouts.layout')
@section('meta_title', 'Add Sample Collection | ChromoXpert')

@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">

            {{-- Hero Header --}}
            <div class="p-4 rounded-4 mb-4 position-relative overflow-hidden shadow-lg"
                 style="background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%); color: #fff;">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="fw-bold mb-1">{{ !empty($sample) ? 'Edit Sample Collection' : 'Add New Sample Collection' }}</h2>
                        <p class="mb-0">Fill in the details to {{ !empty($sample) ? 'update the' : 'create a new' }} sample collection record</p>
                        <a href="{{ url()->previous() }}" 
                           class="btn btn-light btn-lg fw-semibold rounded-pill shadow-sm"
                           style="background: #f6b51d; color: #1f2937; border: none;">
                            <i class="mdi mdi-arrow-left me-2"></i> Back
                        </a>
                    </div>
                </div>
                <div class="position-absolute top-0 end-0 opacity-25" style="font-size: 120px; color: #ac7fb6;">
                    <i class="mdi mdi-test-tube"></i> 
                </div>
            </div>

            {{-- Form Card --}}
            <div class="card border-0 shadow-lg rounded-4" 
                 style="background: rgba(255,255,255,0.85); backdrop-filter: blur(14px);">
                <div class="card-body p-4">
                    
                    @if(isset($sample) && $sample->id)
                        <form action="{{ route('sample.update', $sample->id) }}" method="post">
                            @method('PUT')
                    @else
                        <form action="{{ route('sample-collection.store') }}" method="post">
                    @endif
                        @csrf
                        <input type="hidden" name="id" value="{{ $sample?->id ?? '' }}">

                        <div class="row">
                            {{-- Full Width Column --}}
                            <div class="col-md-12">
                                <div class="row g-3">

                                    {{-- Appointment Code --}}
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select rounded-3" id="appointment_id" name="appointment_id" required>
                                                <option value="">Select Appointment</option>
                                                @if(!empty($appointments))
                                                @foreach ($appointments ?? [] as $appointment)
                                                    <option value="{{ $appointment->id }}" {{ old('appointment_id', $sample?->appointment_id ?? '') == $appointment->id ? 'selected' : '' }}>
                                                        {{ $appointment->appointment_code }} - {{ !empty($appointment->pet) && !empty($appointment->pet->name) ? $appointment->pet->name : ($appointment->patient_name ?? 'N/A') }}
                                                    </option>
                                                @endforeach
                                                @endif
                                            </select>
                                            <label for="appointment_id" style="color: #6267ae;">
                                                <i class="mdi mdi-calendar-check me-1"></i>Appointment*
                                            </label>
                                            @error('appointment_id')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>

                                    {{-- Sample Type --}}
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select rounded-3" id="sample_type" name="sample_type" required>
                                                <option value="">Select Sample Type</option>
                                                <option value="Blood" {{ old('sample_type', $sample?->sample_type ?? '') == 'Blood' ? 'selected' : '' }}>Blood</option>
                                                <option value="Urine" {{ old('sample_type', $sample?->sample_type ?? '') == 'Urine' ? 'selected' : '' }}>Urine</option>
                                                <option value="Stool" {{ old('sample_type', $sample?->sample_type ?? '') == 'Stool' ? 'selected' : '' }}>Stool</option>
                                                <option value="Saliva" {{ old('sample_type', $sample?->sample_type ?? '') == 'Saliva' ? 'selected' : '' }}>Saliva</option>
                                                <option value="Tissue" {{ old('sample_type', $sample?->sample_type ?? '') == 'Tissue' ? 'selected' : '' }}>Tissue</option>
                                            </select>
                                            <label for="sample_type" style="color: #6267ae;">
                                                <i class="mdi mdi-flask me-1"></i>Sample Type*
                                            </label>
                                            @error('sample_type')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>

                                    {{-- Collection Source --}}
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select rounded-3" id="collection_source_id" name="collection_source_id" required>
                                                <option value="">Select Collection Center/Lab/Hospital</option>
                                                @if(!empty($allBranches))
                                                @foreach ($allBranches ?? [] as $branch)
                                                    <option value="{{ $branch->id }}" {{ old('collection_source_id', $sample?->collection_source_id ?? '') == $branch->id ? 'selected' : '' }}>
                                                        {{ !empty($branch->branch_name) ? $branch->branch_name : 'N/A' }} ({{ !empty($branch->branch_code) ? $branch->branch_code : 'N/A' }})
                                                    </option>
                                                @endforeach
                                                @endif
                                            </select>
                                            <label for="collection_source_id" style="color: #6267ae;">
                                                <i class="mdi mdi-map-marker me-1"></i>Collection Source*
                                            </label>
                                            @error('collection_source_id')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>

                                    {{-- Destination Lab --}}
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select rounded-3" id="destination_lab_id" name="destination_lab_id" required>
                                                <option value="">Select Destination Lab</option>
                                                @if(!empty($branches))
                                                @foreach ($branches ?? [] as $branch)
                                                    <option value="{{ $branch->id }}" {{ old('destination_lab_id', $sample?->destination_lab_id ?? '') == $branch->id ? 'selected' : '' }}>
                                                        {{ !empty($branch->branch_name) ? $branch->branch_name : 'N/A' }} ({{ !empty($branch->branch_code) ? $branch->branch_code : 'N/A' }})
                                                    </option>
                                                @endforeach
                                                @endif
                                            </select>
                                            <label for="destination_lab_id" style="color: #6267ae;">
                                                <i class="mdi mdi-laboratory me-1"></i>Sent To Lab*
                                            </label>
                                            @error('destination_lab_id')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>

                                    {{-- Collection Date --}}
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="date" class="form-control rounded-3" id="collection_date" 
                                                name="collection_date" value="{{ old('collection_date', $sample?->collection_date ?? '') }}" placeholder=" " required>
                                            <label for="collection_date" style="color: #6267ae;">
                                                <i class="mdi mdi-calendar me-1"></i>Collection Date*
                                            </label>
                                            @error('collection_date')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>

                                    {{-- Collection Time --}}
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="time" class="form-control rounded-3" id="collection_time" 
                                                name="collection_time" value="{{ old('collection_time', $sample?->collection_time ?? '') }}" placeholder=" " required>
                                            <label for="collection_time" style="color: #6267ae;">
                                                <i class="mdi mdi-clock-outline me-1"></i>Collection Time*
                                            </label>
                                            @error('collection_time')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>

                                    {{-- Notes --}}
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <textarea class="form-control rounded-3" id="notes" 
                                                name="notes" placeholder=" " style="height: 100px;">{{ old('notes', $sample?->notes ?? '') }}</textarea>
                                            <label for="notes" style="color: #6267ae;">
                                                <i class="mdi mdi-note-text me-1"></i>Notes
                                            </label>
                                            @error('notes')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="mt-4 d-flex gap-2 justify-content-start">
                            <button type="submit" class="btn btn-success btn-lg rounded-pill shadow-sm px-4"
                                    style="background: #6267ae; color: #fff; border: none;">
                                <i class="mdi mdi-content-save me-2"></i> {{ !empty($sample) ? 'Update Sample Collection' : 'Save Sample Collection' }}
                            </button>
                            <button type="reset" class="btn btn-secondary btn-lg rounded-pill shadow-sm px-4">
                                <i class="mdi mdi-refresh me-2"></i> Reset
                            </button>
                        </div>
                    </form>
                </div>
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
    }
</style>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        // Auto-populate patient name if appointment selected (assuming AJAX or JS)
        $('#appointment_id').change(function() {
            var appointmentId = $(this).val();
            if (appointmentId) {
                // In real implementation, use AJAX to fetch additional patient details if needed
                // For now, the option already shows pet name or patient name
            }
        });

        // Set default collection date to today if empty
        if (!$('#collection_date').val()) {
            var today = new Date().toISOString().split('T')[0];
            $('#collection_date').val(today);
        }

        // Optional: Set default time to current time if empty
        if (!$('#collection_time').val()) {
            var now = new Date();
            var timeString = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');
            $('#collection_time').val(timeString);
        }
    });
</script>
@endsection
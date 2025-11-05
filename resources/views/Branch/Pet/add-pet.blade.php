@extends('Branch.Layouts.layout')

@section('meta_title', !empty($pet) ? 'Edit Pet | ChromoXpert' : 'Add Pet | ChromoXpert')

@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            {{-- Hero Header with Gradient Background --}}
            <div class="p-4 rounded-4 mb-4 position-relative overflow-hidden shadow-lg"
                 style="background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%); color: #fff;">
                <h2 class="fw-bold mb-1">{{ !empty($pet) ? 'Edit Pet' : 'Add New Pet' }}</h2>
                <p class="mb-0">{{ !empty($pet) ? 'Update the pet details' : 'Register a new pet in the system' }}</p>
                <a href="{{ url()->previous() }}" 
                   class="btn btn-light btn-lg mt-3 fw-semibold rounded-pill shadow-sm"
                   style="background: #f6b51d; color: #1f2937; border: none;">
                    <i class="mdi mdi-arrow-left me-2"></i> Back
                </a>
                <div class="position-absolute top-0 end-0 opacity-25" style="font-size: 120px; color: #ac7fb6;">
                    <i class="mdi mdi-paw"></i>
                </div>
            </div>

            {{-- Glassmorphic Form Card --}}
            <div class="card border-0 shadow-lg rounded-4" 
                 style="background: rgba(255,255,255,0.85); backdrop-filter: blur(14px);">
                <div class="card-body p-4">
                    <form action="{{ route('branch.pet.store') }}" method="POST" enctype="multipart/form-data" id="petForm">
                        @csrf
                        <input type="hidden" name="id" value="{{ $pet->id ?? '' }}">

                        <div class="row g-3">
                            {{-- Pet Parent Selection --}}
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select rounded-3" id="pet_parent_id" name="pet_parent_id" required
                                            style="background: #fff; color: #6267ae; border: 1px solid #f6b51d;">
                                        <option value="" {{ old('pet_parent_id', $pet->pet_parent_id ?? '') ? '' : 'selected' }} disabled>Select Pet Parent</option>
                                        @foreach($petparents as $petparent)
                                            <option value="{{ $petparent->id }}" {{ old('pet_parent_id', $pet->pet_parent_id ?? '') == $petparent->id ? 'selected' : '' }}>{{ $petparent->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="pet_parent_id" style="color: #6267ae;">Pet Parent / Care of*</label>
                                    @error('pet_parent_id')
                                        <span class="text-danger" style="color: #cc235e;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Pet Name Input --}}
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control rounded-3" id="name" name="name" 
                                           placeholder=" " value="{{ old('name', $pet->name ?? '') }}" required
                                           style="background: #fff; color: #6267ae; border: 1px solid #f6b51d;">
                                    <label for="name" style="color: #6267ae;">Pet Name*</label>
                                    @error('name')
                                        <span class="text-danger" style="color: #cc235e;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            {{-- Species Selection --}}
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select rounded-3" id="species" name="species" required
                                            style="background: #fff; color: #6267ae; border: 1px solid #f6b51d;">
                                        <option value="" {{ old('species', $pet->species ?? '') ? '' : 'selected' }} disabled>Select Species</option>
                                        <option value="Canine" {{ old('species', $pet->species ?? '') == 'Canine' ? 'selected' : '' }}>Canine</option>
                                        <option value="Feline" {{ old('species', $pet->species ?? '') == 'Feline' ? 'selected' : '' }}>Feline</option>
                                        <option value="Avian" {{ old('species', $pet->species ?? '') == 'Avian' ? 'selected' : '' }}>Avian</option>
                                        <option value="Other" {{ old('species', $pet->species ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    <label for="species" style="color: #6267ae;">Species*</label>
                                    @error('species')
                                        <span class="text-danger" style="color: #cc235e;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Breed Input with Dynamic Options --}}
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control rounded-3" id="breed" name="breed" 
                                           placeholder=" " value="{{ old('breed', $pet->breed ?? '') }}" list="breedOptions"
                                           style="background: #fff; color: #6267ae; border: 1px solid #f6b51d;">
                                    <datalist id="breedOptions">
                                        <!-- Breed options will be dynamically populated here -->
                                    </datalist>
                                    <label for="breed" style="color: #6267ae;">Breed</label>
                                    @error('breed')
                                        <span class="text-danger" style="color: #cc235e;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Pet Type Selection --}}
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select rounded-3" id="type" name="type" required
                                            style="background: #fff; color: #6267ae; border: 1px solid #f6b51d;">
                                        <option value="" {{ old('type', $pet->type ?? '') ? '' : 'selected' }} disabled>Select Type</option>
                                        <option value="Dog" {{ old('type', $pet->type ?? '') == 'Dog' ? 'selected' : '' }}>Dog</option>
                                        <option value="Cat" {{ old('type', $pet->type ?? '') == 'Cat' ? 'selected' : '' }}>Cat</option>
                                        <option value="Bird" {{ old('type', $pet->type ?? '') == 'Bird' ? 'selected' : '' }}>Bird</option>
                                        <option value="Other" {{ old('type', $pet->type ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    <label for="type" style="color: #6267ae;">Pet Type*</label>
                                    @error('type')
                                        <span class="text-danger" style="color: #cc235e;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Gender Selection --}}
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select rounded-3" id="gender" name="gender" required
                                            style="background: #fff; color: #6267ae; border: 1px solid #f6b51d;">
                                        <option value="" {{ old('gender', $pet->gender ?? '') ? '' : 'selected' }} disabled>Select Gender</option>
                                        <option value="Male" {{ old('gender', $pet->gender ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ old('gender', $pet->gender ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
                                    </select>
                                    <label for="gender" style="color: #6267ae;">Gender*</label>
                                    @error('gender')
                                        <span class="text-danger" style="color: #cc235e;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Date of Birth Input --}}
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control rounded-3" id="dob" name="dob" 
                                           placeholder=" " value="{{ old('dob', $pet->dob ?? '') }}" max="{{ date('Y-m-d') }}"
                                           style="background: #fff; color: #6267ae; border: 1px solid #f6b51d;">
                                    <label for="dob" style="color: #6267ae;">Date of Birth</label>
                                    @error('dob')
                                        <span class="text-danger" style="color: #cc235e;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Age Input (auto/manual) --}}
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control rounded-3" id="age" name="age" 
                                           placeholder=" " value="{{ old('age', $pet->age ?? '') }}"
                                           style="background: {{ old('dob', $pet->dob ?? '') ? '#f8f9fa' : '#fff' }}; color: #6267ae; border: 1px solid #f6b51d;"
                                           {{ old('dob', $pet->dob ?? '') ? 'readonly' : '' }}>
                                    <label for="age" style="color: #6267ae;">Age</label>
                                    @error('age')
                                        <span class="text-danger" style="color: #cc235e;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Weight Input --}}
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="number" step="0.1" min="0" class="form-control rounded-3" id="weight" name="weight" 
                                           placeholder=" " value="{{ old('weight', $pet->weight ?? '') }}"
                                           style="background: #fff; color: #6267ae; border: 1px solid #f6b51d;">
                                    <label for="weight" style="color: #6267ae;">Weight (kg)</label>
                                    @error('weight')
                                        <span class="text-danger" style="color: #cc235e;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Pet Image Input --}}
                            <div class="col-12">
                                <label class="form-label fw-semibold" style="color: #6267ae;">Pet Image</label>
                                <input type="file" data-plugins="dropify" name="image" id="image" 
                                       accept="image/*" 
                                       data-default-file="{{ !empty($pet->image_path) ? asset('storage/' . $pet->image_path) : '' }}"
                                       style="border: 1px solid #f6b51d;" />
                                <p class="text-center mt-2 mb-0 text-muted">Pet Profile Image</p>
                                @error('image')
                                    <span class="text-danger" style="color: #cc235e;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Form Action Buttons --}}
                        <div class="mt-4 d-flex gap-2">
                            <button type="submit" class="btn btn-success btn-lg rounded-pill shadow-sm px-4"
                                    style="background: #6267ae; color: #fff; border: none;" id="submitBtn">
                                <i class="mdi mdi-content-save me-2"></i> {{ !empty($pet) ? 'Update Pet' : 'Add Pet' }}
                                <span class="spinner-border spinner-border-sm text-light ms-2 d-none" id="submitSpinner" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </span>
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
@endsection

@section('style')
<style>
    .form-floating>.form-control, 
    .form-floating>.form-select {
        height: calc(3.5rem + 2px);
    }
    .form-control:focus, .form-select:focus {
        border-color: #f6b51d;
        box-shadow: 0 0 8px rgba(246, 181, 29, 0.5);
    }
    .dropify-wrapper {
        border-radius: 1rem !important;
        border: 1px solid #f6b51d !important;
        background: #fff !important;
    }
    .dropify-wrapper .dropify-message p {
        color: #6267ae !important;
    }
    .spinner-border { vertical-align: middle; }
    @media (max-width: 768px) {
        .btn-lg { font-size: 0.9rem; padding: 0.5rem 1rem; }
        .form-floating label { font-size: 0.9rem; }
    }
</style>
@endsection

@section('scripts')
<script src="{{ asset('assets/libs/dropify/js/dropify.min.js') }}"></script>
<script>
    $(document).ready(function() {
        // Initialize Dropify
        $('#image').dropify({
            messages: {
                'default': 'Drag and drop an image here or click',
                'replace': 'Drag and drop or click to replace',
                'remove': 'Remove',
                'error': 'Oops, something went wrong.'
            }
        });

        // Breed data for different species
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
        $('#species').on('change', function() {
            const species = $(this).val();
            const breedOptions = $('#breedOptions');
            breedOptions.empty();
            
            if (species && breedData[species]) {
                breedData[species].forEach(breed => {
                    breedOptions.append(`<option value="${breed}">`);
                });
            }
        });

        // Helper: parse manual age input like "1 year 2 months 10 days"
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

        // Helper: format age string nicely
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

        // Calculate approximate DOB from age input
        function calculateDOBFromAge(years, months, days) {
            const today = new Date();
            let dob = new Date(today.getFullYear() - years, today.getMonth() - months, today.getDate() - days);
            if (dob.getMonth() > today.getMonth()) {
                dob.setFullYear(dob.getFullYear() - 1);
            }
            return dob;
        }

        // DOB and Age handling
        $('#dob').on('change', function() {
            const dobVal = $(this).val();
            if (dobVal) {
                const dob = new Date(dobVal);
                if (!isNaN(dob.getTime())) {
                    const age = calculateAgeFromDOB(dob);
                    const ageStr = formatAgeString(age.years, age.months, age.days);
                    $('#age').val(ageStr).prop('readonly', true).css('background', '#f8f9fa');
                } else {
                    $('#age').val('').prop('readonly', false).css('background', '#fff');
                }
            } else {
                $('#age').val('').prop('readonly', false).css('background', '#fff');
            }
        });

        $('#age').on('blur', function() {
            if (!$(this).prop('readonly')) {
                const ageStr = $(this).val();
                if (ageStr.trim() === '') {
                    $('#dob').val('');
                    return;
                }
                const age = parseAgeInput(ageStr);
                if (age.years === 0 && age.months === 0 && age.days === 0) {
                    alert('Please enter age in format like "1 year 2 months 10 days" or "10 days" etc.');
                    return;
                }
                const dob = calculateDOBFromAge(age.years, age.months, age.days);
                const yyyy = dob.getFullYear();
                const mm = ('0' + (dob.getMonth() + 1)).slice(-2);
                const dd = ('0' + dob.getDate()).slice(-2);
                $('#dob').val(`${yyyy}-${mm}-${dd}`);
                const formattedAge = formatAgeString(age.years, age.months, age.days);
                $('#age').val(formattedAge).prop('readonly', true).css('background', '#f8f9fa');
            }
        });

        $('#age').on('click', function() {
            if ($(this).prop('readonly')) {
                $(this).prop('readonly', false).css('background', '#fff').val('');
                $('#dob').val('');
            }
        });

        // Weight validation
        $('#weight').on('input', function() {
            const value = parseFloat($(this).val());
            if (value < 0) {
                $(this).val('');
                alert('Weight cannot be negative.');
            }
        });

        // Form submission handler
        $('#petForm').on('submit', function(e) {
            $('#submitSpinner').removeClass('d-none');
            $('#submitBtn').prop('disabled', true);
        });

        // Trigger species change on page load
        @if(old('species') || !empty($pet->species))
            $('#species').val('{{ old('species', $pet->species ?? '') }}').trigger('change');
            $('#breed').val('{{ old('breed', $pet->breed ?? '') }}');
        @endif
    });
</script>
@endsection
@extends('Admin.Layouts.layout')
@section('meta_title', 'Pet Details | ChromoXpert')

@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            {{-- Hero Header with Gradient Background --}}
            <div class="p-4 rounded-4 mb-4 position-relative overflow-hidden shadow-lg"
                 style="background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%); color: #fff;">
                <h2 class="fw-bold mb-1">Pet Details</h2>
                <p class="mb-0">View details of the selected pet</p>
                <div class="position-absolute top-0 end-0 opacity-25" style="font-size: 120px; color: #ac7fb6;">
                    <i class="mdi mdi-paw" aria-hidden="true"></i>
                </div>
            </div>

            {{-- Glassmorphic Card for Pet Details --}}
            <div class="card border-0 shadow-lg rounded-4"
                 style="background: rgba(255,255,255,0.85); backdrop-filter: blur(14px);">
                <div class="card-body p-4">
                    <div class="row g-3">
                        @php
                            $fields = [
                                ['label' => 'Pet Code', 'value' => $pet->pet_code],
                                ['label' => 'Pet Parent', 'value' => $pet->petParent->name ?? null],
                                ['label' => 'Name', 'value' => $pet->name],
                                ['label' => 'Species', 'value' => $pet->species],
                                ['label' => 'Breed', 'value' => $pet->breed],
                                ['label' => 'Type', 'value' => $pet->type],
                                ['label' => 'Gender', 'value' => $pet->gender],
                                ['label' => 'Date of Birth', 'value' => $pet->dob],
                                ['label' => 'Age', 'value' => $pet->age],
                                ['label' => 'Weight', 'value' => $pet->weight ? $pet->weight . ' kg' : null],
                            ];
                        @endphp

                        @foreach ($fields as $field)
                            <div class="col-md-6 fade-in-row">
                                <label class="fw-semibold text-primary" style="color: #6267ae;">{{ $field['label'] }}</label>
                                <p class="mb-0">{{ $field['value'] ?? 'N/A' }}</p>
                            </div>
                        @endforeach

                        {{-- Pet Image --}}
                        <div class="col-md-6 fade-in-row">
                            <label class="fw-semibold text-primary" style="color: #6267ae;" for="pet-image">Pet Image</label>
                            @if($pet->image_path)
                                <div class="mt-2">
                                    <img id="pet-image"
                                            src="{{ Storage::url($pet->image_path) }}"
                                            alt="{{ $pet->name ?? 'Pet' }} Image"
                                            class="pet-image rounded-3 shadow-sm"
                                            onerror="this.onerror=null; this.src='/images/placeholder-pet.png'"
                                            style="width: 150px; height: 150px; object-fit: cover; object-position: center;">

                                </div>
                            @else
                                <p class="mb-0">N/A</p>
                            @endif
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="mt-4 d-flex gap-3 justify-content-start flex-wrap">
                        <a href="{{ url('admin/pet') }}"  
                           class="btn btn-outline-danger btn-lg rounded-pill shadow-sm px-4 d-flex align-items-center">
                            <i class="mdi mdi-arrow-left me-2" aria-hidden="true"></i> Back to Pets
                        </a>
                        @if(auth()->guard('master_admins')->user() && \App\Models\Master\Role_privilege::where('id', auth()->guard('master_admins')->user()->role_id)->where('status', 'active')->where('privileges', 'like', '%pet_edit%')->exists())
                            <a href="{{ url('admin/pet/edit/' . $pet->id) }}"  
                               class="btn btn-outline-warning btn-lg rounded-pill shadow-sm px-4 d-flex align-items-center">
                                <i class="mdi mdi-pencil me-2" aria-hidden="true"></i> Edit Pet
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('style')
<style>
    .fade-in-row { 
        animation: fadeInUp 0.6s ease-in-out; 
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .pet-image {
        max-width: 150px;
        max-height: 150px;
        object-fit: contain;
    }

    .text-primary {
        color: #6267ae !important;
    }

    @media (max-width: 768px) {
        .card-body { padding: 1.5rem; }
        .pet-image { max-width: 100px; max-height: 100px; }
        .btn-lg { font-size: 0.9rem; padding: 0.5rem 1rem; }
    }
</style>
@endsection

@section('script')
<script>
    $(function () {
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
</script>
@endsection
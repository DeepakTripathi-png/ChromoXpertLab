@extends('Branch.Layouts.layout')
@section('meta_title', 'Test Components | ChromoXpert')

@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">

            {{-- Hero Header --}}
            <div class="p-4 rounded-4 position-relative overflow-hidden shadow-lg"
                 style="background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%); color: #fff;">
                <h2 class="fw-bold mb-1">Tests & Components</h2>
                <p class="mb-0">Manage test results and component details</p>

                <div class="mt-3 mb-3 text-right">
                    <a href="{{ url('branch/report') }}" 
                       class="btn btn-light btn-lg mt-3 fw-semibold rounded-pill shadow-sm"
                       style="background: #f6b51d; color: #1f2937; border: none;">
                        <i class="mdi mdi-arrow-left me-2"></i> Back
                    </a>
                </div>

                <div class="position-absolute top-0 end-0 opacity-25" style="font-size: 120px; color: #ac7fb6;">
                    <i class="mdi mdi-flask"></i>
                </div>
            </div>


            {{-- Action Buttons --}}

            <div class="row">
                <div class="col-md-12 d-flex justify-content-end">
                    <div class="mt-3 mb-3 display-flex gap-2">
                        <a href="#" class="btn btn-light btn-lg fw-semibold rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#animalInfoModal"
                           style="background: #f6b51d; color: #1f2937; border: none;">
                            <i class="mdi mdi-paw me-2"></i> Animal Info
                        </a>
                        <a href="{{ url('branch/reports/view/'.$id) }}" class="btn btn-light btn-lg fw-semibold rounded-pill shadow-sm"
                           style="background: #cc235e; color: #fff; border: none;">
                            <i class="mdi mdi-file-pdf me-2"></i> Print Report
                        </a>
                    </div>
                </div>
            </div>

            {{-- Tab Navigation --}}
            <ul class="nav nav-tabs mb-3" style="border: none;">
                @if(!empty($tests))
                    @foreach($tests as $index => $test)
                        <li class="nav-item">
                            <a class="nav-link text-uppercase fw-bold {{ $index === 0 ? 'active' : '' }}" 
                               href="#test{{ $test->id }}" 
                               data-bs-toggle="tab">
                                {{ $test->name ?? '' }}
                            </a>
                        </li>
                    @endforeach
                @endif    
            </ul>

            {{-- Glassmorphic Card --}}
            <div class="card border-0 shadow-lg rounded-4"
                 style="background: rgba(255,255,255,0.85); backdrop-filter: blur(14px);">
                <div class="card-body p-3">
                    <div class="tab-content">
                        @if(!empty($tests))
                            @foreach($tests as $index => $test)
                                <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" 
                                     id="test{{ $test->id }}">
                                    <form method="POST" action="{{ url('branch/reports/store') }}">
                                        @csrf
                                        <input type="hidden" name="test_id" value="{{ $test->id }}">
                                        <input type="hidden" name="appointment_id" value="{{ $appointment->id ?? '' }}">
                                        <input type="hidden" name="test_result_code" value="{{ $report->first()->test_result_code ?? '' }}">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered align-middle mb-0">
                                                <thead style="background: linear-gradient(135deg, #ac7fb6 0%, #f6b51d 100%); color: #fff;">
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Unit</th>
                                                        <th>Reference Range</th>
                                                        <th>Result</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($test->parameters as $param)
                                                        @if($param->row_type === 'title')
                                                            <tr>
                                                                <td colspan="5" class="text-start fw-bold">
                                                                    {{ $param->title }}
                                                                </td>
                                                            </tr>
                                                        @elseif($param->row_type === 'component')
                                                           
                                                            {{-- Find the corresponding TestResultComponent for this parameter and test --}}
                                                            @php
                                                                $testResult = $report->where('test_id', $test->id)->first();
                                                                $component = $testResult ? $testResult->components->where('component_id', $param->id)->first() : null;
                                                            @endphp
                                                            <tr>
                                                                <td>{{ $param->name }}</td>
                                                                <td>{{ $param->unit }}</td>
                                                                <td>{{ $param->reference_range }}</td>
                                                                <td>
                                                                    @if($param->result_type === 'select')
                                                                        <select name="results[{{ $test->id }}][{{ $param->id }}]" 
                                                                                class="form-select form-select-sm">
                                                                            <option value="" {{ !$component || !$component->result ? 'selected' : '' }}>Select option</option>
                                                                            @foreach($param->options as $option)
                                                                                <option value="{{ $option->option_value }}" 
                                                                                        {{ $component && $component->result === $option->option_value ? 'selected' : '' }}>
                                                                                    {{ $option->option_value }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    @else
                                                                    <input type="text" 
                                                                           name="results[{{ $test->id }}][{{ $param->id }}]" 
                                                                           class="form-control form-control-sm" 
                                                                           value="{{ $component ? $component->result : '' }}" />
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <select name="status[{{ $test->id }}][{{ $param->id }}]" 
                                                                            class="form-select form-select-sm">
                                                                        <option value="" {{ !$component || !$component->result_status ? 'selected' : '' }}>Select status</option>
                                                                        <option value="normal" {{ $component && $component->result_status === 'normal' ? 'selected' : '' }}>Normal</option>
                                                                        <option value="abnormal" {{ $component && $component->result_status === 'abnormal' ? 'selected' : '' }}>Abnormal</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @empty
                                                        <tr>
                                                            <td colspan="5" class="text-center text-muted">
                                                                No parameters found
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>

                                        {{-- Comment --}}
                                        <div class="mt-3">
                                            <textarea name="comments[{{ $test->id }}]" 
                                                      class="form-control form-control-sm" 
                                                      rows="3" 
                                                      placeholder="Comment">{{ $testResult ? $testResult->comment : '' }}</textarea>
                                        </div>

                                        {{-- Save Button --}}
                                        <div class="mt-3">
                                            <button type="submit" 
                                                    class="btn btn-lg rounded-pill shadow-sm"
                                                    style="background: #6267ae; color: #fff; border: none;">
                                                <i class="bi bi-check-lg me-2"></i> Save
                                            </button>
                                        </div>
                                    </form>    
                                </div>
                            @endforeach
                        @endif  
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Animal Info Modal -->
<div class="modal fade" id="animalInfoModal" tabindex="-1" aria-labelledby="animalInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4" style="background: rgba(255,255,255,0.85); backdrop-filter: blur(14px);">
            <div class="modal-header" style="background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%); color: #fff;">
                <h5 class="modal-title" id="animalInfoModalLabel">Animal Info</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="mb-2"><strong>Name:</strong> {{ $appointment->pet->name ?? '' }}</p>
                <p class="mb-2"><strong>Gender:</strong> {{ $appointment->pet->gender ?? '' }}</p>
                <p class="mb-2"><strong>Date of birth:</strong> {{ $appointment->pet->dob ?? '' }}</p>
                <p class="mb-2"><strong>Age:</strong> {{ $appointment->pet->age ?? '' }}</p>
                <p class="mb-2"><strong>Owner name:</strong> {{ $appointment->pet->petparent->name ?? '' }}</p>
                <p class="mb-2"><strong>Phone:</strong> {{ $appointment->pet->petparent->mobile ?? '' }}</p>
                <p class="mb-2"><strong>Email:</strong> {{ $appointment->pet->petparent->email ?? '' }}</p>
                <p class="mb-2"><strong>Address:</strong> {{ $appointment->pet->petparent->address ?? '' }}</p>
            </div>
            <div class="modal-footer" style="background: linear-gradient(135deg, #ac7fb6 0%, #f6b51d 100%);">
                <button type="button" class="btn btn-light rounded-pill shadow-sm" style="background: #fff; color: #6267ae; border: none;" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('style')
<style>
    /* Tabs */
    .nav-tabs .nav-link.active {
        background: #fff !important;
        color: #6267ae !important;
        border: none !important;
        font-weight: 700;
    }
    .nav-tabs .nav-link { color: #fff !important; border-radius: 0 !important; }

    /* Table */
    table.table td, table.table th {
        padding: 8px 10px !important;
        vertical-align: middle !important;
        font-size: 0.9rem;
    }
    .form-control-sm, .form-select-sm {
        font-size: 0.9rem;
        border-radius: 4px;
        border: 1px solid #f6b51d;
        color: #6267ae;
        background: #fff;
    }
    .form-control-sm::placeholder { color: #999; }

    /* Buttons */
    button.btn-lg {
        transition: all 0.2s ease-in-out;
    }
    button.btn-lg:hover { opacity: 0.9; }

    /* Switch Toggle */
    .switch { position: relative; display: inline-block; width: 44px; height: 24px; }
    .switch input { opacity: 0; width: 0; height: 0; }
    .slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; transition: .4s; border-radius: 24px; }
    .slider:before { position: absolute; content: ""; height: 18px; width: 18px; left: 3px; bottom: 3px; background-color: white; transition: .4s; border-radius: 50%; }
    input:checked + .slider { background: linear-gradient(135deg, #6267ae 0%, #f6b51d 100%); box-shadow: 0 0 10px #f6b51d; }
    input:checked + .slider:before { transform: translateX(20px); }
</style>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var triggerTabList = [].slice.call(document.querySelectorAll('.nav-link'))
        triggerTabList.forEach(function(triggerEl) {
            var tabTrigger = new bootstrap.Tab(triggerEl)
            triggerEl.addEventListener('click', function(e) {
                e.preventDefault()
                tabTrigger.show()
            })
        })
    })
</script>
@endsection
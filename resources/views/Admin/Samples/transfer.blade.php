@extends('Admin.Layouts.layout')

@section('meta_title', 'Transfer Sample')

@section('style')
/* Reuse glass-card and gradient-header from above */
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="glass-card p-4 rounded shadow">
                <div class="gradient-header text-white p-3 rounded mb-3">
                    <h4 class="mb-0"><i class="fas fa-exchange-alt me-2"></i>Transfer Sample</h4>
                </div>
                <form action="{{ route('samples.transfer.store', $sample) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Sample Code</label>
                        <input type="text" class="form-control" value="{{ $sample->sample_code }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">From Branch</label>
                        <input type="text" class="form-control" value="{{ $sample->branch->name }}" readonly>
                        <input type="hidden" name="from_branch_id" value="{{ $sample->branch_id }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">To Branch <span class="text-danger">*</span></label>
                        <select name="to_branch_id" class="form-select @error('to_branch_id') is-invalid @enderror" required>
                            <option value="">Select Destination</option>
                            @foreach($branches as $branch)
                                @if($branch->id != $sample->branch_id)
                                    <option value="{{ $branch->id }}">{{ $branch->name }} ({{ $branch->location }})</option>
                                @endif
                            @endforeach
                        </select>
                        @error('to_branch_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Transfer Notes</label>
                        <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-info"><i class="fas fa-paper-plane me-1"></i>Initiate Transfer</button>
                    <a href="{{ route('samples.index') }}" class="btn btn-secondary ms-2">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
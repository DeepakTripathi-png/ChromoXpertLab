@extends('Branch.Layouts.layout')
@section('meta_title', 'Invoice | ChromoXpert')

@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            {{-- Hero Header --}}
            <div class="p-4 rounded-4 mb-4 position-relative overflow-hidden shadow-lg"
                 style="background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%); color: #fff;">
                <h2 class="fw-bold mb-1">Invoice</h2>
                <p class="mb-0">Pet Test & Billing Details</p>
                <a href="{{ url('branch/appointments') }}" 
                   class="btn btn-light btn-lg mt-3 fw-semibold rounded-pill shadow-sm"
                   style="background: #f6b51d; color: #1f2937; border: none;">
                    <i class="mdi mdi-arrow-left me-2"></i> Back
                </a>
                <div class="position-absolute top-0 end-0 opacity-25" style="font-size: 120px; color: #ac7fb6;">
                    <i class="mdi mdi-receipt"></i>
                </div>
            </div>

            {{-- Invoice Card --}}
            <div class="card border-0 shadow-lg rounded-4 mb-4"
                 style="background: rgba(255,255,255,0.9); backdrop-filter: blur(12px);">
                <div class="card-body p-4">
                    {{-- Appointment & Pet Info --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <p><strong style="color: #6267ae;">Appointment Code:</strong> {{ $appointmentDetails->appointment_code ?? 'N/A' }}</p>
                            <p><strong style="color: #6267ae;">Animal Code:</strong> {{ $appointmentDetails->pet->pet_code ?? 'N/A' }}</p>
                            <p><strong style="color: #6267ae;">Owner Code:</strong> {{ $appointmentDetails->pet->petParent->code ?? 'N/A' }}</p>
                            <p><strong style="color: #6267ae;">Age:</strong> {{ $appointmentDetails->pet->age ?? 'N/A' }}</p>
                            <p><strong style="color: #6267ae;">Referee Doctor:</strong> {{ $appointmentDetails->refereeDoctor->doctor_name ?? 'Self' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong style="color: #6267ae;">Animal Name:</strong> {{ $appointmentDetails->pet->name ?? 'N/A' }}</p>
                            <p><strong style="color: #6267ae;">Owner Name:</strong> {{ $appointmentDetails->pet->petParent->name ?? 'N/A' }}</p>
                            <p><strong style="color: #6267ae;">Gender:</strong> {{ $appointmentDetails->pet->gender ?? 'N/A' }}</p>
                            <p><strong style="color: #6267ae;">Appointment Date & Time:</strong> 
                                {{ \Carbon\Carbon::parse($appointmentDetails->appointment_date . ' ' . $appointmentDetails->appointment_time)->format('d M Y, g:i A') }}
                            </p>
                        </div>
                    </div>

                    {{-- Invoice Table --}}
                    <div class="table-responsive rounded-3 shadow-sm mb-4">
                        <table class="table table-bordered align-middle mb-0">
                            <thead style="background: linear-gradient(135deg, #ac7fb6 0%, #f6b51d 100%); color: #fff;">
                                <tr>
                                    <th>Test Name</th>
                                    <th>Price (₹)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($appointmentDetails->tests as $test)
                                    <tr>
                                        <td class="text-start">{{ $test->name }}</td>
                                        <td>{{ number_format($test->base_price, 2) }} ₹</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Totals --}}
                    <div class="d-flex justify-content-end">
                        <div class="p-3 rounded-3 shadow-sm"
                             style="background: rgba(98,103,174,0.1); min-width: 250px;">
                            <p class="d-flex justify-content-between mb-1">
                                <span><strong>Subtotal</strong></span><span>{{ number_format($appointmentDetails->subtotal, 2) }} ₹</span>
                            </p>
                            <p class="d-flex justify-content-between mb-1">
                                <span><strong>Discount</strong></span><span>{{ number_format($appointmentDetails->discount, 2) }} ₹</span>
                            </p>
                            <p class="d-flex justify-content-between mb-1">
                                <span><strong>Total</strong></span><span>{{ number_format($appointmentDetails->total, 2) }} ₹</span>
                            </p>
                            <p class="d-flex justify-content-between mb-1">
                                <span><strong>Paid Amount</strong></span><span>{{ number_format($appointmentDetails->paid_amount, 2) }} ₹</span>
                            </p>
                            <p class="d-flex justify-content-between mb-0">
                                <span><strong>Due Amount</strong></span><span>{{ number_format($appointmentDetails->due_amount, 2) }} ₹</span>
                            </p>
                            
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="mt-4 d-flex gap-2">
                        <a href="{{ route('branch.invoice.print', $appointmentDetails->id) }}" 
                           target="_blank" 
                           class="btn btn-primary btn-lg rounded-pill shadow-sm px-4"
                           style="background: #5e5e9d; border-color: #5e5e9d; color: #fff;">
                            <i class="mdi mdi-printer me-2"></i> Print Receipt
                        </a>
                        <button class="btn btn-secondary btn-lg rounded-pill shadow-sm px-4"
                                style="background: #a86b9a; border-color: #a86b9a; color: #fff;"
                                data-bs-toggle="modal" 
                                data-bs-target="#barcodeModal"
                                data-appointment-id="{{ $appointmentDetails->id }}">
                            <i class="mdi mdi-barcode me-2"></i> Print Barcode
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Barcode Modal --}}
<div class="modal fade" id="barcodeModal" tabindex="-1" aria-labelledby="barcodeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow-lg" style="border: none;">
            <div class="modal-header" style="background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%); color: #fff;">
                <h5 class="modal-title fw-bold" id="barcodeModalLabel">Print Barcode</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label for="sampleCount" class="form-label fw-semibold" style="color:#6267ae;">Number of Samples</label>
                    <input type="number" id="sampleCount" class="form-control rounded-3 shadow-sm" min="1" value="1">
                </div>
                <div id="barcodeDetails" class="mb-3">
                    <p><strong>Appointment Code:</strong> <span id="appointmentCode">N/A</span></p>
                </div>
                <div id="barcodePreview" class="mt-3 text-center">
                    <!-- Barcode will be loaded here dynamically -->
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-danger rounded-pill shadow-sm px-4" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-warning rounded-pill shadow-sm px-4" id="printBarcodeBtn">
                    <i class="mdi mdi-printer me-1"></i> Print
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('style')
<style>
    .table th, .table td {
        vertical-align: middle;
    }
    .table-bordered th, .table-bordered td {
        border-color: #f6b51d !important;
    }
    .btn-lg {
        font-size: 1rem;
        padding: 0.75rem 1.5rem;
    }
    .btn-warning {
        background: #f6b51d;
        border-color: #f6b51d;
        color: #1f2937;
    }
    .btn-warning:hover {
        background: #e0a21a;
        border-color: #e0a21a;
    }
    .modal-backdrop {
        z-index: 1040 !important;
        background-color: rgba(0, 0, 0, 0.5);
    }
    .modal {
        z-index: 1055 !important;
    }
    .modal-content {
        position: relative;
        z-index: 1060;
    }
    #barcodeDetails p {
        margin-bottom: 0.5rem;
    }
    #barcodePreview img {
        max-width: 100%;
    }
</style>
@endsection

@section('script')
<script>
function loadBarcodePreview(appointmentId, sampleCount) {
    if (!appointmentId) {
        document.getElementById('barcodePreview').innerHTML = '<p class="text-danger">Appointment ID is missing. Please try again.</p>';
        document.getElementById('appointmentCode').textContent = 'N/A';
        console.error('Missing appointmentId');
        return;
    }

    if (sampleCount < 1 || isNaN(sampleCount)) {
        document.getElementById('barcodePreview').innerHTML = '<p class="text-danger">Please enter a valid number of samples (minimum 1).</p>';
        document.getElementById('appointmentCode').textContent = 'N/A';
        console.error('Invalid sampleCount:', sampleCount);
        return;
    }

    console.log('Fetching barcode for appointmentId:', appointmentId, 'sampleCount:', sampleCount);
    fetch('{{ url("branch/barcode") }}/' + appointmentId + '?sample_count=' + sampleCount, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok: ' + response.statusText);
        }
        return response.json();
    })
    .then(data => {
        console.log('Barcode data received:', data);
        document.getElementById('barcodePreview').innerHTML = data.barcode || '<p class="text-danger">No barcode data received.</p>';
        document.getElementById('appointmentCode').textContent = data.appointment_code || 'N/A';
    })
    .catch(error => {
        console.error('Error loading barcode:', error);
        document.getElementById('barcodePreview').innerHTML = '<p class="text-danger">Failed to load barcode. Please try again.</p>';
        document.getElementById('appointmentCode').textContent = 'N/A';
    });
}

document.getElementById('barcodeModal').addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const appointmentId = button.getAttribute('data-appointment-id');
    const sampleCount = parseInt(document.getElementById('sampleCount').value) || 1;
    loadBarcodePreview(appointmentId, sampleCount);
});

document.getElementById('sampleCount').addEventListener('input', function () {
    const button = document.querySelector('[data-bs-target="#barcodeModal"]');
    const appointmentId = button ? button.getAttribute('data-appointment-id') : null;
    const sampleCount = parseInt(this.value) || 1;
    loadBarcodePreview(appointmentId, sampleCount);
});

document.getElementById('printBarcodeBtn').addEventListener('click', function () {
    const button = document.querySelector('[data-bs-target="#barcodeModal"]');
    const appointmentId = button ? button.getAttribute('data-appointment-id') : null;
    const sampleCount = parseInt(document.getElementById('sampleCount').value) || 1;

    if (!appointmentId) {
        alert('Appointment ID is missing. Please try again.');
        console.error('Missing appointmentId for print');
        return;
    }

    if (sampleCount < 1 || isNaN(sampleCount)) {
        alert('Please enter a valid number of samples (minimum 1).');
        console.error('Invalid sampleCount for print:', sampleCount);
        return;
    }

    // Open print window
    console.log('Opening print window for appointmentId:', appointmentId, 'sample_count:', sampleCount);
    const printWindow = window.open('{{ url("branch/barcode") }}/' + appointmentId + '?sample_count=' + sampleCount, '_blank', 'width=600,height=800');
    if (printWindow) {
        printWindow.onload = function () {
            console.log('Print window loaded, checking content');
            if (printWindow.document.body.innerHTML.includes('barcode-container')) {
                console.log('Barcode content detected, triggering print');
                printWindow.print();
            } else {
                console.error('Barcode content not found in print window');
                alert('Barcode failed to load in print window. Please try again or allow pop-ups.');
            }
        };
        // Fallback timer if onload doesn't trigger
        setTimeout(() => {
            if (printWindow && !printWindow.closed) {
                console.log('Fallback timer triggered, checking print window');
                if (printWindow.document.body.innerHTML.includes('barcode-container')) {
                    printWindow.print();
                } else {
                    console.error('Fallback: Barcode content not found');
                    alert('Barcode failed to load. Please try again or check pop-up settings.');
                }
            }
        }, 2000);
    } else {
        alert('Failed to open print window. Please allow pop-ups in your browser settings and try again.');
        console.error('Print window blocked or failed to open');
    }

    // Save barcode via POST
    console.log('Saving barcode for appointmentId:', appointmentId, 'sampleCount:', sampleCount);
    fetch('{{ route('barcode.save') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ appointment_id: appointmentId, sample_count: sampleCount })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok: ' + response.statusText);
        }
        return response.json();
    })
    .then(data => {
        if (data.status === 'success') {
            console.log('Barcode saved:', data.files);
            alert('Barcodes saved successfully!');
        } else {
            console.error('Error saving barcode:', data.message);
            alert('Failed to save barcodes: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error saving barcode:', error);
        alert('Failed to save barcodes. Please try again.');
    });

    // Hide modal
    const modal = bootstrap.Modal.getInstance(document.getElementById('barcodeModal'));
    modal.hide();
});
</script>
@endsection
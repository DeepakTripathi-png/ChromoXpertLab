<?php

namespace App\Http\Controllers\Admin\Invoice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; 
use App\Models\Appointment;

class InvoiceController extends Controller
{
    public function generateInvoice($id)
    {
        $appointmentDetails = Appointment::with(['branch', 'refereeDoctor', 'pet', 'pet.petParent', 'tests'])
                            ->where('id', $id)
                            ->first();

        if (!$appointmentDetails) {
            return response()->json(['error' => 'Appointment not found'], 404); // Friendlier error
        }
        
        $pdf = Pdf::loadView('Admin.Invoice.invoice', compact('appointmentDetails'))
                ->setPaper('A4', 'portrait');

        return $pdf->download('invoice_' . $id . '.pdf');
    }
}
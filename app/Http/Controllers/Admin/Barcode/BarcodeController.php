<?php

namespace App\Http\Controllers\Admin\Barcode;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Picqer\Barcode\BarcodeGeneratorHTML;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Illuminate\Support\Facades\Storage;
use App\Models\Appointment;
use Illuminate\Support\Str;

class BarcodeController extends Controller
{
    public function show(Request $request, $appointment_id)
    {
        $request->merge(['appointment_id' => $appointment_id]);
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'sample_count' => 'integer|min:1|max:100',
        ]);

        $appointment = Appointment::findOrFail($appointment_id);
        $sampleCount = $request->query('sample_count', 1);
        $generatorHTML = new BarcodeGeneratorHTML();

        $barcodes = [];
        for ($i = 0; $i < $sampleCount; $i++) {
            $barcodes[] = $generatorHTML->getBarcode($appointment->appointment_code, BarcodeGeneratorHTML::TYPE_CODE_128);
        }
        $barcode = implode('<br><hr><br>', $barcodes);
        $appointment_code = $appointment->appointment_code;

        if ($request->ajax()) {
            return response()->json([
                'barcode' => $barcode,
                'appointment_code' => $appointment_code,
            ]);
        }

        return view('Admin.Barcode.barcode', compact('barcode', 'sampleCount', 'appointment_code'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'sample_count' => 'integer|min:1|max:100',
        ]);

        $appointment = Appointment::findOrFail($request->input('appointment_id'));
        $sampleCount = $request->input('sample_count', 1);
        $generatorPNG = new BarcodeGeneratorPNG();
        $filePaths = [];

        try {
            for ($i = 0; $i < $sampleCount; $i++) {
                $image = $generatorPNG->getBarcode($appointment->appointment_code, $generatorPNG::TYPE_CODE_128);
                $fileName = "barcodes/{$appointment->appointment_code}_" . Str::uuid() . ".png";
                Storage::disk('public')->put($fileName, $image);
                $filePaths[] = Storage::url($fileName);
            }

            return response()->json([
                'status' => 'success',
                'files' => $filePaths,
                'appointment_code' => $appointment->appointment_code,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to save barcode: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function printBarcodeDirectly($appointment_id, $sampleCount = 1)
    {
        $appointment = Appointment::findOrFail($appointment_id);
        $generatorPNG = new BarcodeGeneratorPNG();

        try {
            for ($i = 0; $i < $sampleCount; $i++) {
                $image = $generatorPNG->getBarcode($appointment->appointment_code, $generatorPNG::TYPE_CODE_128);
                
                // Convert PNG Image to raw TSPL command
                $base64Image = base64_encode($image);
                $tsplCommand = "^XA^FO50,50^XGR:BARCODE.GRF,1,1^FS^XZ";  // Example (You need to adjust this based on your printer)
                
                // Or send RAW image data (depends on printer support)
                $printerIp = '192.168.1.100';
                $printerPort = 9100;
                
                $socket = fsockopen($printerIp, $printerPort);
                if (!$socket) {
                    throw new \Exception("Unable to connect to printer at {$printerIp}:{$printerPort}");
                }
                
                // Example: Sending TSPL Command directly
                $command = "^XA^FO50,50^BY3^BCN,100,Y,N,N^FD{$appointment->appointment_code}^FS^XZ";
                fwrite($socket, $command);
                
                fclose($socket);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Barcode sent to printer successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Printing failed: ' . $e->getMessage(),
            ], 500);
        }
    }

}
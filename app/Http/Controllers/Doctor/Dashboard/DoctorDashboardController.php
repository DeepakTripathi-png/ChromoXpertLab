<?php

namespace App\Http\Controllers\Doctor\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\InternalDoctor;
use App\Models\TestResults;

class DoctorDashboardController extends Controller
{
    public function index()
    {

        $doctorUser = Auth::guard('doctor')->user();
        $doctor = InternalDoctor::where('user_id',$doctorUser->id)->first();

         $reports = TestResults::with([
                'appointment.pet.petparent',
                'test',
                'assignedDoctor'
            ])
            ->select('test_results.*') 
            ->join('appointments', 'test_results.appointment_id', '=', 'appointments.id') 
            ->where('test_results.assigned_to_doctor_id', $doctor->id) // Branch-specific filter
            ->orderBy('test_results.created_at', 'DESC') // Sort by created_at DESC to get latest first
            ->get()
            ->groupBy('test_result_code')
            ->map(function($group) {
                $first = $group->first(); // Since the collection is already sorted by created_at DESC, first() will be the latest
                $tests = $group->pluck('test')->filter()->values();

                return (object)[
                    'test_result_code' => $first->test_result_code,
                    'appointment'      => $first->appointment,
                    'tests'            => $tests,
                    'doctor_approval_status' => $first->doctor_approval_status ?? 'pending',
                    'priority'         => $first->priority ?? 'Medium',
                    'status'           => $first->status,
                    'signed_by_id'      => $first->signed_by_id,
                    'created_at'       => $first->created_at,
                    'assigned_doctor'  => $first->assignedDoctor ? $first->assignedDoctor->doctor_name : 'Not Assigned',
                ];
            })
            ->values();

        // Separate reports by approval status for tabs
        $pendingReportsData = $reports->filter(function($report) {
            return $report->doctor_approval_status === 'pending';
        });

        $approvedReportsData = $reports->filter(function($report) {
            return $report->doctor_approval_status === 'approved';
        });

        $rejectedReportsData = $reports->filter(function($report) {
            return $report->doctor_approval_status === 'rejected';
        });

            $pendingReports = TestResults::where('assigned_to_doctor_id',$doctor->id)
                ->where('doctor_approval_status','pending')
                ->distinct('test_result_code')
                ->count('test_result_code');

            $rejectedReports = TestResults::where('assigned_to_doctor_id',$doctor->id)
                ->where('doctor_approval_status','rejected')
                ->distinct('test_result_code')
                ->count('test_result_code');

            $approvedReports = TestResults::where('assigned_to_doctor_id',$doctor->id)
                ->where('doctor_approval_status','approved')
                ->distinct('test_result_code')
                ->count('test_result_code');


        return view('Doctor.Dashboard.index',compact('reports','pendingReports','rejectedReports','approvedReports', 'pendingReportsData', 'approvedReportsData', 'rejectedReportsData'));
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestResults extends Model
{
    use HasFactory;

    protected $table = 'test_results';

    protected $fillable = [
        'test_result_code',
        'appointment_id',
        'test_id',
        'priority', 
        'status',   
        'comment',
        'signed_by_id',
        'signed_date',
        'assigned_to_doctor_id',
        'assigned_at',
        'assigned_by',
        'done',
        'created_ip_address',
        'modified_ip_address',
        'created_by',
        'modified_by',
        'doctor_approval_status',
        'doctor_approved_at',
        'doctor_rejection_comment',
        'admin_approved',
        'rejection_reason',
        'admin_approved_at',
        'admin_approved_by'
    ];

    protected $casts = [
        'admin_approved' => 'boolean',
        'doctor_approved_at' => 'datetime',
        'admin_approved_at' => 'datetime',
        'signed_date' => 'datetime',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }

    public function test()
    {
        return $this->belongsTo(Test::class, 'test_id');
    }

    public function components()
    {
        return $this->hasMany(TestResultComponent::class, 'test_result_id');
    }

    public function assignedDoctor()
    {
        return $this->belongsTo(InternalDoctor::class, 'assigned_to_doctor_id');
    }

    public function assignedByUser()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function adminApprover()
    {
        return $this->belongsTo(User::class, 'admin_approved_by');
    }

    public function getIsCompleteAttribute()
    {
        return $this->done === 'yes' || $this->admin_approved;
    }

    public function getDoctorApproverAttribute()
    {
        return $this->assignedDoctor;
    }
}
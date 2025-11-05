<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'appointments';

    protected $fillable = [
        'appointment_code',
        'lab_id',
        'referee_doctor_id',
        'appointment_date',
        'appointment_time',
        'pet_id',
        'petowner_id',
        'notes',
        'subtotal',
        'discount',
        'gst',
        'total',
        'paid_amount',
        'due_amount',
        'created_ip_address',
        'modified_ip_address',
        'created_by',
        'modified_by',
        'status',
        'payment_mode',
        'transaction_id',
        'payment_status',
        'payment_date',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'lab_id');
    }

    public function refereeDoctor()
    {
        return $this->belongsTo(RefereeDoctor::class, 'referee_doctor_id');
    }

    public function pet()
    {
        return $this->belongsTo(Pet::class, 'pet_id');
    }

    public function petOwner()
    {
        return $this->belongsTo(PetParent::class, 'petowner_id');
    }

    public function tests()
    {
        return $this->belongsToMany(Test::class, 'appointment_tests', 'appointment_id', 'test_id')
                    ->withPivot('price');
    }
}

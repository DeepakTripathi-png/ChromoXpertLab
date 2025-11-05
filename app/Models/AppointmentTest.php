<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentTest extends Model
{
    use HasFactory;

    protected $table = 'appointment_tests';

    protected $fillable = [
        'appointment_id',
        'test_id',
        'price',
    ];
}
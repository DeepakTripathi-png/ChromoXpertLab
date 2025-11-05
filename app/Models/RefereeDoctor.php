<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefereeDoctor extends Model
{
    use HasFactory;

     protected $table = 'referee_doctors';

     protected $fillable = [
            'code',
            'doctor_name',
            'gender',
            'email',
            'mobile',
            'commission_percent',
            'address',
            'created_ip_address',
            'modified_ip_address',
            'created_by',
            'modified_by',
            'status'
    ];
}

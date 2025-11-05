<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class InternalDoctor extends Model
{
    use HasFactory;

    protected $table = 'internal_doctors';

    protected $fillable = [
        'user_id',
        'code',
        'doctor_name',
        'gender',
        'email',
        'mobile',
        'role_id',
        'address',
        'doctor_image_name',
        'doctor_image_path',
        'doctor_sign_name',
        'doctor_sign_path',
        'created_ip_address',
        'modified_ip_address',
        'created_by',
        'modified_by',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function role()
    {
        return $this->belongsTo(\App\Models\Master\Role_privilege::class, 'role_id');
    }
}
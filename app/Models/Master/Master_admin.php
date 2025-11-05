<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Master_admin extends Model
{
    use HasFactory;

    protected $table = 'master_admins';

    protected $fillable = [
        'user_type',
        'user_id',
        'user_name',
        'email',
        'password',
        'mobile_no',
        'role_id',
        'address',
        'user_profile_image_path',
        'user_profile_image_name',
        'fcm_token',
        'access_token',
        'last_login',
        'otp',
        'status',
        'created_ip_address',
        'modified_ip_address',
        'created_by',
        'modified_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'last_login' => 'datetime',
    ];
}
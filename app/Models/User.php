<?php

namespace App\Models;

use App\Models\Master\Master_admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'name',
        'email',
        'password',
        'mobile',
        'address',
        'status',
        'last_login',
        'role_id',
        'created_ip_address',
        'modified_ip_address',
        'created_by',
        'modified_by',
        'otp',
		'otp_expires_at',
		'otp_attempts',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login' => 'datetime',
        'password' => 'hashed',
        'otp_expires_at' => 'datetime',
    ];

    /**
     * Scope for filtering users by type (e.g., for multi-auth guards)
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope for active users only
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Check if user is active
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }


    // User model mein yeh relationships add karen
    public function branch()
    {
        return $this->hasOne(Branch::class, 'user_id');
    }

    public function masterAdmin()
    {
        return $this->hasOne(Master_admin::class, 'user_id');
    }

    public function internalDoctor()
    {
        return $this->hasOne(InternalDoctor::class, 'user_id');
    }

}
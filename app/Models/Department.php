<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Master\Master_admin;

class Department extends Model
{
    use HasFactory;

    protected $table = 'departments';

    protected $fillable = [
        'description',
        'code',
        'department_name',
        'email',
        'mobile',
        'department_head',
        'created_ip_address',
        'modified_ip_address',
        'created_by',
        'modified_by',
        'status'
    ];

    /**
     * Define the relationship with Master_admin for department_head.
     */
    public function head()
    {
        return $this->belongsTo(Master_admin::class, 'department_head', 'id');
    }
}
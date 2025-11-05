<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visual_setting extends Model
{
    use HasFactory;
    protected $fillable = [
        'logo_image_path',
        'logo_image_name',
        'mini_logo_image_path',
        'mini_logo_image_name',
        'logo_email_image_path',
        'logo_email_image_name',
        'favicon_image_path',
        'favicon_image_name',

        'created_ip_address',
        'modified_ip_address',
        'created_by',
        'modified_by',
        'status',
    ];
}

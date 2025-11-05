<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Petparent;

class Pet extends Model
{
    use HasFactory;

    protected $table = 'pets';

    protected $fillable = [
        'pet_code',
        'pet_parent_id',
        'name',
        'species',
        'breed',
        'type',
        'gender',
        'dob',
        'age',
        'weight',
        'image_name',
        'image_path',
        'status',
        'created_by',
        'created_ip_address',
        'modified_by',
        'modified_ip_address',
    ];

    public function petParent()
    {
        return $this->belongsTo(Petparent::class, 'pet_parent_id');
    }
}
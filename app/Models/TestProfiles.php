<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestProfiles extends Model
{
    use HasFactory;


    protected $table = 'test_profiles';

    protected $fillable = [
               'name',
              'profile_code',
              'profile_description',
              'profile_price',
              'created_ip_address',
              'modified_ip_address',
              'created_by',
              'modified_by',
              'status'
    ];


    public function tests()
    {
        return $this->belongsToMany(Test::class, 'test_profile_tests','test_profile_id');
    }

}

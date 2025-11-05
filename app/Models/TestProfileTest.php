<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestProfileTest extends Model
{
    use HasFactory;


       protected $table = 'test_profile_tests';

        protected $fillable = [
                  'test_profile_id',
                   'test_id'
        ];
    }

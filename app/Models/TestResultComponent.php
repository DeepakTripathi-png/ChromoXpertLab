<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestResultComponent extends Model
{
    use HasFactory;

    protected $table = 'test_result_components';

    protected $fillable = [
             'test_result_id',
             'component_id',
             'result',
             'result_status', 
    ];

}

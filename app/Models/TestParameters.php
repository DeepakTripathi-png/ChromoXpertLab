<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestParameters extends Model
{
    use HasFactory;

    protected $table = 'test_parameters';

    protected $fillable = [
        'test_id',
        'row_type',
        'name',
        'title',
        'unit',
        'result_type',
        'reference_range',
        'sort_order',
        'created_ip_address',
        'modified_ip_address',
        'created_by',
        'modified_by',
        'status',
    ];

    public function test()
    {
        return $this->belongsTo(Test::class, 'test_id');
    }

    public function options()
    {
        return $this->hasMany(ParameterOptions::class, 'parameter_id')->where('status', 'active');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParameterOptions extends Model
{
    use HasFactory;



     protected $table = 'parameter_options';

     protected $fillable = [
             'parameter_id',
             'option_value',
              'sort_order',
             'created_ip_address',
             'modified_ip_address',
             'created_by',
             'modified_by',
             'status', 
        ];

    public function parameter()
    {
        return $this->belongsTo(TestParameters::class, 'parameter_id');
    }

}

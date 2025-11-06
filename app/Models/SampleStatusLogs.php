<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SampleStatusLogs extends Model
{
    use HasFactory;

    protected $fillable = [
        'sample_id',
        'changed_by',
        'from_status',
        'to_status',
        'remarks',
        'changed_at',
    ];

    public function sample()
    {
        return $this->belongsTo(SampleCollection::class, 'sample_id');
    }
}

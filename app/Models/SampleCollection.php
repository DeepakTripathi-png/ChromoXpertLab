<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SampleCollection extends Model
{
    use HasFactory;

    protected $table = 'sample_collections';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sample_code',
        'appointment_id',
        'sample_type',
        'collection_source_id',
        'destination_lab_id',
        'status',
        'collection_date',
        'collection_time',
        'notes',
        'created_ip_address',
        'modified_ip_address',
        'created_by',
        'modified_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'collection_date' => 'date',
        'collection_time' => 'datetime:H:i',
    ];

    // Relationships (similar to Branch model)
    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }

    public function collectionSource()
    {
        return $this->belongsTo(Branch::class, 'collection_source_id');
    }

    public function destinationLab()
    {
        return $this->belongsTo(Branch::class, 'destination_lab_id');
    }

   
    // Scopes for status filtering (e.g., SampleCollection::pending()->get())
    public function scopePending($query)
    {
        return $query->where('status', 'Pending');
    }

    public function scopeCollected($query)
    {
        return $query->where('status', 'Collected');
    }

    public function scopeInTransit($query)
    {
        return $query->where('status', 'In Transit');
    }

    public function scopeReceived($query)
    {
        return $query->where('status', 'Received');
    }

    public function scopeProcessing($query)
    {
        return $query->where('status', 'Processing');
    }

    public function scopeAnalyzed($query)
    {
        return $query->where('status', 'Analyzed');
    }

    public function scopeReported($query)
    {
        return $query->where('status', 'Reported');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'Completed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'Cancelled');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'Rejected');
    }

    // Helper method to get status badge class (for views)
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'Pending' => 'warning',
            'Collected' => 'info',
            'In Transit' => 'primary',
            'Received' => 'success',
            'Processing' => 'warning',
            'Analyzed' => 'info',
            'Reported' => 'success',
            'Completed' => 'secondary',
            'Cancelled' => 'danger',
            'Rejected' => 'danger',
        ];

        return $badges[$this->status] ?? 'secondary';
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id',
        'date',
        'kilometer',
        'description',
        'status'
    ];

    protected $casts = [
        'date' => 'date',
        'kilometer' => 'integer'
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function serviceNotes()
    {
        return $this->hasMany(ServiceNote::class);
    }

    public function getTotalCostAttribute()
    {
        return $this->serviceNotes->sum('cost');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('date', now()->month)
                    ->whereYear('date', now()->year);
    }
} 
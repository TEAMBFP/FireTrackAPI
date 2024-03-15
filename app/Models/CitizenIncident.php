<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CitizenIncident extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'type',
        'location',
        'fire_station_id',
        'image',
        'barangay',
        'alarm_level_id'
    ];

    protected $casts = [
        'created_at' => 'datetime:m/d/Y H:i:s',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function station()
    {
        return $this->belongsTo(FireStation::class);
    }

    public function details()
    {
        return $this->hasOne(IncidentDetails::class);
    }

    public function alarmLevel()
    {
        return $this->belongsTo(AlarmLevel::class);
    }
}

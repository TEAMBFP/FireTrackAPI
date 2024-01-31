<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        'address',
        'contact_number',
        'fire_station_id',
        'district_id',
        'region_id'
    ];

    public function fireStation()
    {
        return $this->belongsTo(FireStation::class);
    }

    public function district()
    {
        return $this->belongsTo(Districts::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}

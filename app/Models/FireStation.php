<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FireStation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'latitude',
        'longitude',
        'number',
        'district_id'
    ];

    public function district()
    {
        return $this->belongsTo(Districts::class);
    }

    public function region()
    {
        return $this->district->region;
    }
}


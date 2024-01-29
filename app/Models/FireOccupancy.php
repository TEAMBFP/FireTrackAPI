<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FireOccupancy extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'fire_type_id'
    ];
    public function fireType()
    {
        return $this->belongsTo(FireType::class);
    }
}

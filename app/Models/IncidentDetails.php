<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentDetails extends Model
{
    use HasFactory;
     protected $fillable = [
        'incident_id',
        'responder',
        'incident',
        'status',
    ];

    public function details()
    {
        return $this->belongsTo(Incident::class);
    }
}

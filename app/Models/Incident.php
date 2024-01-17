<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'type',
        'location',
        'station',
        'image',
        'barangay',
    ];

    protected $casts = [
    'created_at' => 'datetime:m/d/Y H:i:s',
];
}

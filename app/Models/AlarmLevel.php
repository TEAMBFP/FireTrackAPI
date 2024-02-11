<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlarmLevel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function incidents()
    {
        return $this->hasMany(Incident::class);
    }
}

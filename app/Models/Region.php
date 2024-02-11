<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'contact',
        'user_id'
    ];

    public function districts()
    {
        return $this->hasMany(District::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Models\Audit;



class IncidentDetails extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
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

      protected static function booted()
    {
        static::created(function ($model) {
            $audit = new Audit([
                'user_id' => auth()->id(),
                'event' => 'created',
                'auditable_id' => $model->incident_id,
                'auditable_type' => get_class($model),
                'old_values' => [],
                'new_values' => $model->getAttributes(),
                'url' => request()->fullUrl(),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            $audit->save();
        });
    }

     public function getKeyName()
    {
        return 'incident_id';
    }
}

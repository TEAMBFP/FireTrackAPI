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

    public function transformAudit(array $data): array
    {
        // Add the incident_id to the new_values
        $data['new_values']['incident_id'] = $this->incident_id;

        return $data;
    }

}

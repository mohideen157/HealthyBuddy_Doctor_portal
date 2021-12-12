<?php

namespace Myaibud\Models\Patient;

use Illuminate\Database\Eloquent\Model;

class PatientHealthProfile extends Model
{
    protected $table = 'patient_health_profile';

    protected $fillable = [
        'patient_id',
        'parent_key',
        'child_key',
        'value',
        'unit',
        'extra_info',
        'active',
        'score'
    ];

    public function scopeGetHealthData($query, $id)
    {
        return $query->where('patient_id', $id);
    }
}

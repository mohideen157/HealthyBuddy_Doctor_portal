<?php

namespace Myaibud\Models\Patient;

use Illuminate\Database\Eloquent\Model;

class PatientHraData extends Model
{
    protected $table = 'patient_hra_data';

    protected $casts = [
    	'hra' => 'array'
    ];
}

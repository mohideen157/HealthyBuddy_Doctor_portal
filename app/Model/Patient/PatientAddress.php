<?php

namespace App\Model\Patient;

use Illuminate\Database\Eloquent\Model;

class PatientAddress extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'patient_addresses';

    public function scopeDefault($query)
	{
		return $query->where('default', '=', 1);
	}
}

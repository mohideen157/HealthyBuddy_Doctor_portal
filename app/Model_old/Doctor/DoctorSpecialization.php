<?php

namespace App\Model\Doctor;

use Illuminate\Database\Eloquent\Model;

class DoctorSpecialization extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'doctor_specialization';

    /**
	 * Get the specialization
	 */
	public function specialization()
	{
	    return $this->belongsTo('App\Model\Doctor\DocSpecialization', 'specialization_id', 'id');
	}
}

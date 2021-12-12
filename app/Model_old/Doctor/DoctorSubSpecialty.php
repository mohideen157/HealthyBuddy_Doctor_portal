<?php

namespace App\Model\Doctor;

use Illuminate\Database\Eloquent\Model;

class DoctorSubSpecialty extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'doctor_subspecialty';

    /**
	 * Get the user that owns the phone.
	 */
	public function specialty()
	{
	    return $this->belongsTo('App\Model\Specialty', 'specialty_id', 'id');
	}
}

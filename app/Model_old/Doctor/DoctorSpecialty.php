<?php

namespace App\Model\Doctor;

use Illuminate\Database\Eloquent\Model;

class DoctorSpecialty extends Model
{
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'doctor_specialty';

	/**
	 * Get the user that owns the phone.
	 */
	public function specialty()
	{
		return $this->belongsTo('App\Model\Specialty', 'specialty_id', 'id');
	}
}

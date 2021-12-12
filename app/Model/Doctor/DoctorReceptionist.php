<?php

namespace App\Model\Doctor;

use Illuminate\Database\Eloquent\Model;

class DoctorReceptionist extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'receptionist';

	/**
	 * Get the doctor userdata
	 */
	public function userdata()
	{
		return $this->belongsTo('App\User', 'receptionist_id', 'id');
	}

	/**
	 * Get the doctor
	 */
	public function doctor()
	{
		return $this->belongsTo('App\Doctor\DoctorProfile', 'doctor_id', 'doctor_id');
	}
}

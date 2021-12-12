<?php

namespace App\Model\Doctor;

use Illuminate\Database\Eloquent\Model;

class DoctorLedger extends Model
{
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'doctor_ledger';

	/**
	 * Get the appointments prescriptions
	 */
	public function appointmentCallStatus()
	{
		return $this->hasOne('App\Model\Appointment\AppointmentCallStatus', 'appointment_id', 'appointment_id');
	}
}

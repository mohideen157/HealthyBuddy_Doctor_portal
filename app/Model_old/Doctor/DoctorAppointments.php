<?php

namespace App\Model\Doctor;

use Illuminate\Database\Eloquent\Model;

class DoctorAppointments extends Model
{
	 /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'doctor_appointments';

	/**
	 * Get the appointments prescriptions
	 */
	public function appointmentPrescription()
	{
		return $this->hasOne('App\Model\Appointment\AppointmentPrescription', 'appointment_id', 'id');
	}

	/**
	 * Get the appointments prescriptions
	 */
	public function appointmentCallStatus()
	{
		return $this->hasOne('App\Model\Appointment\AppointmentCallStatus', 'appointment_id', 'id');
	}
}

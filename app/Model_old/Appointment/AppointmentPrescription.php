<?php

namespace App\Model\Appointment;

use Illuminate\Database\Eloquent\Model;

class AppointmentPrescription extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'appointment_prescription';

    /**
	 * Get the doctor receptionist
	 */
	public function labtests()
	{
		return $this->hasMany('App\Model\Appointment\AppointmentPrescriptionLabTest', 'prescription_id', 'id');
	}

	/**
	 * Get the doctor receptionist
	 */
	public function medicines()
	{
		return $this->hasMany('App\Model\Appointment\AppointmentPrescriptionMedicines', 'prescription_id', 'id');
	}


	public function appointment(){
		return $this->belongsTo('App\Model\Doctor\DoctorAppointments', 'appointment_id', 'id');
	}
}

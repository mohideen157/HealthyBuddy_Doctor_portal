<?php

namespace App\Model\Appointment;

use Illuminate\Database\Eloquent\Model;

class TempAppointment extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'temp_appointment_bookings';

    /**
	 * Get the slot details for this temp booking
	 */
	public function slotDetails()
	{
	    return $this->belongsTo('App\Model\Doctor\DoctorTimeSlots', 'slot_id', 'id');
	}

	/**
	 * Get the doctorProfile for this temp booking
	 */
	public function doctorProfile()
	{
	    return $this->belongsTo('App\Model\Doctor\DoctorProfile', 'doctor_id', 'doctor_id');
	}
}

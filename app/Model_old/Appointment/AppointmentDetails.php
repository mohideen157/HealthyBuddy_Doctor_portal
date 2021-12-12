<?php

namespace App\Model\Appointment;

use Illuminate\Database\Eloquent\Model;

class AppointmentDetails extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'appointment_details';

    /**
	 * Get the appointments patient reports
	 */
	public function appointmentPatientReports()
	{
		return $this->hasMany('App\Model\Appointment\AppointmentPatientReports', 'appointment_details_id', 'id');
	}
}

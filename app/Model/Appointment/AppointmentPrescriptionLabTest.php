<?php

namespace App\Model\Appointment;

use Illuminate\Database\Eloquent\Model;

class AppointmentPrescriptionLabTest extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'appointment_prescription_lab_tests';

    /**
	 * Get the prescription
	 */
	public function prescription()
	{
		return $this->belongsTo('App\Model\Appointment\AppointmentPrescription', 'prescription_id', 'id');
	}
}

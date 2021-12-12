<?php

namespace App\Model\Appointment;

use Illuminate\Database\Eloquent\Model;

class AppointmentPrescriptionMedicines extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'appointment_prescription_medicines';

    /**
	 * Get the prescription
	 */
	public function prescription()
	{
		return $this->belongsTo('App\Model\Appointment\AppointmentPrescription', 'prescription_id', 'id');
	}
}

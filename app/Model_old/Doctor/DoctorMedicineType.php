<?php

namespace App\Model\Doctor;

use Illuminate\Database\Eloquent\Model;

class DoctorMedicineType extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'doctor_medicine_type';

    /**
	 * Get the user that owns the phone.
	 */
	public function medicineType()
	{
	    return $this->belongsTo('App\Model\MedicineType', 'medicine_type_id', 'id');
	}
}

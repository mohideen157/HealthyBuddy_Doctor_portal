<?php

namespace App\Model\Doctor;

use Illuminate\Database\Eloquent\Model;

class DoctorDocuments extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'doctor_documents';

    /**
	 * Get the doctor profile
	 */
	public function profile()
	{
		return $this->belongsTo('App\Model\Doctor\DoctorProfile', 'doctor_id', 'doctor_id');
	}
}

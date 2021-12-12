<?php

namespace App\Model\Patient;

use Illuminate\Database\Eloquent\Model;

class PatientProfile extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'patient_profile';

    /**
	 * Get the patient addresses
	 */
	public function addresses()
	{
		return $this->hasMany('App\Model\Patient\PatientAddress', 'patient_id', 'patient_id');
	}

    /**
     * Get the patient credits
     */
    public function credits()
    {
        return $this->hasOne('App\Model\Patient\PatientCredits', 'patient_id', 'patient_id');
    }

    /**
     * Get the patient creditlogs
     */
    public function creditlogs()
    {
        return $this->hasMany('App\Model\Patient\PatientCreditLogs', 'patient_id', 'patient_id');
    }
}

<?php

namespace App\Model\Patient;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PatientProfile extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'patient_profile';

    protected $fillable = [        
        'first_name',
        'last_name',
        'gender',
        'dob',
        'app_image',
        'national_id',
        'height_feet',
        'height_inch',
        'height_cm',
        'bmi',
        'blood_group',
        'weight_kg',
        'weight_pounds',
        'occupation'
    ];

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

<?php

namespace App\Model\Symptomcheck;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Auth;

class patientcovid19 extends Model
{
 
 protected $table='patient_covid19';
 /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'id',
		'user_id',
		'mobile_no',
		'triage_level',
		'label',
		'description',
		'serious',
        'root_cause',
        'checked_datetime'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	

}

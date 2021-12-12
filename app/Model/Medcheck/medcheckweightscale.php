<?php

namespace App\Model\Medcheck;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Auth;

class medcheckweightscale extends Model
{
 
 protected $table='patient_weight_scale';
 /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'id',
		'user_id',
		'bmi_weight',
		'bmi',
		'fat_per',
		'muscle_per',
		'water_per',
		'bmr',
		'device_reading_time',
		'mobile_no'

	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	

}

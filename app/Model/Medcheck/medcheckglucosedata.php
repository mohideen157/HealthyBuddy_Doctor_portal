<?php

namespace App\Model\Medcheck;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Auth;

class medcheckglucosedata extends Model
{
 
 protected $table='patient_gulcosedata';
 /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'id',
		'user_id',
		'high_blood',
		'low_blood',
		'indicator',
		'reading_type',		
		'device_reading_time',
		'mobile_no'	

	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	

}

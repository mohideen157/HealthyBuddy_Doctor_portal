<?php

namespace App\Model\Medcheck;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Auth;

class medcheckspo2 extends Model
{
 
 protected $table='patient_spo2';
 /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'id',
		'user_id',
		'spo2_value',
		'pr',
		'pi',
		'spo2_result',
		'device_reading_time',
		'mobile_no'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	

}

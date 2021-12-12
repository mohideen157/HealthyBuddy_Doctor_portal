<?php

namespace App\Model\Medcheck;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Auth;

class medcheckecgdata extends Model
{
 
 protected $table='patient_ecg';
 /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'id',
		'user_id',
		'hr',
		'qrs',
		'qt',
		'qtc',
		'ecg_result',
		'arr_ecg_content',
		'arr_ecg_heartrate',
		'mobile_no',
		'device_reading_time'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	

}

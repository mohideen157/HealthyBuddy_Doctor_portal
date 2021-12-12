<?php

namespace App\Model\Medcheck;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Auth;

class medcheckuser extends Model
{
 
 protected $table='histories';
 /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'id',
		'user_id',
		'afib',
		'arrhythmia',
		'artrialaga',
		'bp',
		'hr',
		'hrvlevel',
		'rpwv',
		'synched',
		'event',
		'date',
		'device_reading_time',
		'mobile_no',
		'status'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	

}

<?php

namespace App\Model\Insurance;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Auth;

class insurancenumber extends Model
{
 
 protected $table='insurance';
 /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'id',
		'insur_code',
		'application_no',
		'memeber_id',
		'is_active',
		'misc1',
		'misc2',
		'created_at',
		'updated_at'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	

}

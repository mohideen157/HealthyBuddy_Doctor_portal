<?php

namespace App\Model\Medcheck;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Auth;

class medcheckuserstable extends Model
{
 
 protected $table='users';
 /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'id',
		'shdct_user_id',
		'user_role',
		'name',
		'email',
		'email_verified',
		'mobile_no',
		'mobile_verified',
		'password',
		'online',
		'active',
		'referred_by',
		'profile_image',
		'profile_image_default',
		'provider',
		'provider_id',
		'organisation_id',
		'tenant_slug'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	

}

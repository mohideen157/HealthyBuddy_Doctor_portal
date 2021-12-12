<?php

namespace App;

use App\Model\History;
use App\Model\Notification;
use App\Model\Patient\PatientAdvice;
use Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
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
	protected $hidden = [
		'password', 'remember_token',
	];

	/**
	 * Get the doctor userRole
	 */
	public function userRole()
	{
		return $this->hasOne('App\Model\UserRole', 'id', 'user_role');
	}

	public function organistion(){
		return $this->hasOne('App\User', 'id', 'organisation_id')->withDefault();
	}

	//role for tenant is 9
	public function tenant_details()
	{
		return $this->hasOne('App\Model\TenantDetail', 'user_id', 'id');
	}

	//role is 10
	public function organisation_details()
	{
		return $this->hasOne('App\Model\Tenant\OrganisationDetail', 'user_id', 'id');
	}

	public function tenant_organisation_details()
	{
		return $this->hasMany('App\Model\Tenant\OrganisationDetail', 'parent_user_id', 'id');
	}

	//role is 2
	public function doctor()
	{
		return $this->hasOne('App\Model\Doctor', 'user_id', 'id');
	}

	/**
	 * Get the doctorProfile
	 */
	public function doctorProfile()
	{
		return $this->hasOne('App\Model\Doctor\DoctorProfile', 'doctor_id', 'id');
	}

	public function patientProfile()
	{
		return $this->hasOne('App\Model\Patient\PatientProfile', 'patient_id', 'id')->withDefault();
	}

	public function patientHhi()
	{
		return $this->hasMany('App\Model\Patient\PatientHhi', 'patient_id', 'id');
	}

	public function patientHealthProfile()
	{
		return $this->hasMany('Myaibud\Models\Patient\PatientHealthProfile', 'patient_id', 'id');
	}

	public function patientHraData()
	{
		return $this->hasOne('Myaibud\Models\Patient\PatientHraData', 'patient_id', 'id');
	}

	public function patientHraDataDevice2()
	{
		return $this->hasOne('Myaibud\Models\Patient\PatientHealthProfile', 'patient_id', 'id')->where('parent_key', 'hra-band-data')->where('child_key', 'device-2')->where('active', 1);
	}

	public function history()
	{
		return $this->hasMany(History::class);
	}

	public function advice(){
		return $this->hasMany(PatientAdvice::class);
	}

	// For phone app
	public function showProfilePageOrNot()
	{
		$heightIsThere = false;
		$weightIsThere = false;

		if (!empty($this->patientProfile->height_feet) ||
		!empty($this->patientProfile->height_inch) ||
		!empty($this->patientProfile->height_cm)  ) {
			$heightIsThere = true;
		}

		if (!empty($this->patientProfile->weight) ||
		!empty($this->patientProfile->weight_kg) ||
		!empty($this->patientProfile->weight_pounds)  ) {
			$weightIsThere = true;
		}
		if ($heightIsThere && $weightIsThere) {
			return false;
		} else {
			return true;
		}

	}


	public function profileQuestion()
	{
		return $this->hasMany('App\ProfileQuestion', 'patient_id', 'id');
	}

	/**
	 * Get the user notifications
	 */
	public function notifications()
	{
		return $this->hasMany('App\Model\Notification', 'user_id', 'id');
	}


	/**
	 * Create the user notifications
	 */
	public function newNotification()
    {
        $notification = new Notification;
        $notification->user()->associate($this);

        return $notification;
    }

    public static function isDoctor()
    {
    	return (Auth::user()->user_role == 2) ? true : false;
    }

    public static function isTenant()
    {
    	return (Auth::user()->user_role == 9) ? true : false; 
    }

   	public static function isOrganisation()
   	{
   		return (Auth::user()->user_role == 10) ? true : false; 
   	}
   	public static function Caregiver()
	{
	 return (Auth::user()->user_role == 11) ? true : false; 
	}
	
}

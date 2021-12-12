<?php

namespace App\Model\Doctor;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class DoctorProfile extends Model
{
	use Sluggable;
	use SluggableScopeHelpers;

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'doctor_profile';

	/**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

	/**
	 * Get the doctor userdata
	 */
	public function userdata()
	{
		return $this->belongsTo('App\User', 'doctor_id', 'id');
	}

	/**
	 * Get the doctor documents
	 */
	public function documents()
	{
		return $this->hasOne('App\Model\Doctor\DoctorDocuments', 'doctor_id', 'doctor_id');
	}

	/**
	 * Get the doctor receptionist
	 */
	public function receptionist()
	{
		return $this->hasOne('App\Model\Doctor\DoctorReceptionist', 'doctor_id', 'doctor_id');
	}

	/**
	 * Get the doctor appointments
	 */
	public function appointments()
	{
		return $this->hasMany('App\Model\Doctor\DoctorAppointments', 'doctor_id', 'doctor_id');
	}

	/**
	 * Get the doctor awards
	 */
	public function awards()
	{
		return $this->hasMany('App\Model\Doctor\DoctorAwards', 'doctor_id', 'doctor_id')->orderBy('year', 'desc');
	}

	/**
	 * Get the doctor bankDetails
	 */
	public function bankDetails()
	{
		return $this->hasMany('App\Model\Doctor\DoctorBankDetails', 'doctor_id', 'doctor_id');
	}

	/**
	 * Get the doctor consultationPrices
	 */
	public function consultationPrices()
	{
		return $this->hasMany('App\Model\Doctor\DoctorConsultationPrices', 'doctor_id', 'doctor_id');
	}

	/**
	 * Get the doctor education
	 */
	public function education()
	{
		return $this->hasMany('App\Model\Doctor\DoctorEducation', 'doctor_id', 'doctor_id')->orderBy('year', 'asc');
	}

	/**
	 * Get the doctor languages
	 */
	public function languages()
	{
		return $this->hasMany('App\Model\Doctor\DoctorLanguages', 'doctor_id', 'doctor_id');
	}

	/**
	 * Get the doctor location
	 */
	public function location()
	{
		return $this->hasOne('App\Model\Doctor\DoctorLocation', 'doctor_id', 'doctor_id');
	}

	/**
	 * Get the doctor medicineType
	 */
	public function medicineType()
	{
		return $this->hasOne('App\Model\Doctor\DoctorMedicineType', 'doctor_id', 'doctor_id');
	}

	/**
	 * Get the doctor services
	 */
	public function services()
	{
		return $this->hasMany('App\Model\Doctor\DoctorServices', 'doctor_id', 'doctor_id');
	}

	/**
	 * Get the doctor signature
	 */
	public function signature()
	{
		return $this->hasOne('App\Model\Doctor\DoctorSignature', 'doctor_id', 'doctor_id');
	}

	/**
	 * Get the doctor specialization
	 */
	public function specialization()
	{
		return $this->hasMany('App\Model\Doctor\DoctorSpecialization', 'doctor_id', 'doctor_id');
	}

	/**
	 * Get the doctor specialty
	 */
	public function specialty()
	{
		return $this->hasOne('App\Model\Doctor\DoctorSpecialty', 'doctor_id', 'doctor_id');
	}

	/**
	 * Get the doctor specialty
	 */
	public function subspecialty()
	{
		return $this->hasMany('App\Model\Doctor\DoctorSubSpecialty', 'doctor_id', 'doctor_id');
	}

	/**
	 * Get the doctor timeSlots
	 */
	public function timeSlots()
	{
		return $this->hasMany('App\Model\Doctor\DoctorTimeSlots', 'doctor_id', 'doctor_id');
	}

	/**
	 * Get the doctor commission slab
	 */
	public function commissionSlab()
	{
		return $this->hasOne('App\Model\DoctorCommissionSlabs', 'id', 'commission_slab');
	}
}

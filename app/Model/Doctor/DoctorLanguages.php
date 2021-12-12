<?php

namespace App\Model\Doctor;

use Illuminate\Database\Eloquent\Model;

class DoctorLanguages extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'doctor_languages';

    /**
	 * Get the user that owns the phone.
	 */
	public function language()
	{
	    return $this->belongsTo('App\Model\Language', 'language_id', 'id');
	}
}

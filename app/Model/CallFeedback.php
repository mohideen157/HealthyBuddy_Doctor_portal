<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CallFeedback extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'appointment_call_feedback';

    public function appointment(){
		return $this->belongsTo('App\Model\Doctor\DoctorAppointments', 'appointment_id', 'id');
	}
}

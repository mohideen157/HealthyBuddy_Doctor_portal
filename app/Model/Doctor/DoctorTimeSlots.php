<?php

namespace App\Model\Doctor;

use Illuminate\Database\Eloquent\Model;

class DoctorTimeSlots extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'doctor_time_slots';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
}

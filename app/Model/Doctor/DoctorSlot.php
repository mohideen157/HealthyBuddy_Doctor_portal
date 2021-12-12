<?php

namespace App\Model\Doctor;

use Illuminate\Database\Eloquent\Model;

class DoctorSlot extends Model
{
 protected $table = 'doctor_slots';
 protected $fillable = ['doctor_id','slot'];
}

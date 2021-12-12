<?php

namespace App\Model\Patient;

use Illuminate\Database\Eloquent\Model;

class PatientHhi extends Model
{
    protected $table="patient_hhi";

    public function patient(){
    	return $this->belongsTo('App\User', 'patient_id', 'id');
    }
}

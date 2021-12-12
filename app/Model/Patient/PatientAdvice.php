<?php

namespace App\Model\Patient;

use App\User;
use Illuminate\Database\Eloquent\Model;

class PatientAdvice extends Model
{
    protected $table = "patient_advices";

    protected $fillable = ['patient_id', 'type', 'description'];

    public function user(){
    	return $this->belongsTo(User::class);
    }

    public function doctor(){
    	return $this->belongsTo(User::class);
    }
}

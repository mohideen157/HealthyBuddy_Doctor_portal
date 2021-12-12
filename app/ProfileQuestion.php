<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfileQuestion extends Model
{
    protected $table = 'patient_profile_question_answer';

    protected $fillable = [
    	'patient_id',
    	'question_slug',
    	'answer'
    ];

    public $upsertRules = [
    	'question_slug' => 'required',
    	'answer' => 'required'
    ];
}

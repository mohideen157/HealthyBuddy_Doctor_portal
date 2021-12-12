<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Padometer extends Model
{
    protected $table = 'pedometer';

    protected $fillable = [
        'patient_id',
        'date',
        'steps'
    ];
}

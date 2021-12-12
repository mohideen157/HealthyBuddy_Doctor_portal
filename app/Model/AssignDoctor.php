<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class AssignDoctor extends Model
{
    protected $table="assign_doctors";

    public function organisation()
    {
    	return $this->belongsTo('App\User', 'org_user_id', 'id');
    }

    public function doctor()
    {
    	return $this->belongsTo('App\User', 'doctor_user_id', 'id');
    }

    public function tenant()
    {
    	return $this->belongsTo('App\User', 'tenant_user_id', 'id');
    }
}

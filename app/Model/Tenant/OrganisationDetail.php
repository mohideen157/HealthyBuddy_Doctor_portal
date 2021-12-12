<?php

namespace App\Model\Tenant;

use Illuminate\Database\Eloquent\Model;

class OrganisationDetail extends Model
{
    protected $table = "organisation_details"; 

    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function parent_user()
    {
    	return $this->belongsTo('App\User', 'parent_user_id','id');
    }
}

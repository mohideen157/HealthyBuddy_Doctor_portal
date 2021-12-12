<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TenantDetail extends Model
{
    protected $table = "tenant_details";

    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function organisation_details()
    {
    	return $this->hasMany('App\Model\Tenant\OrganisationDetail', 'tenant_details_id', 'id');
    }
}

<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\User;
class DietPlan extends Model
{
    protected $table="diet_plans";
    protected $hidden=['created_at','updated_at'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}

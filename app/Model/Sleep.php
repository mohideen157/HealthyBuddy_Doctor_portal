<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Sleep extends Model
{
    protected $table="sleeps";
    protected $hidden=['created_at','updated_at'];
}

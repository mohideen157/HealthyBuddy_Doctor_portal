<?php

namespace App\Model;

use App\User;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;

class HealthTip extends Model
{
	// use Sluggable;
    // use SluggableScopeHelpers;


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'health_tips';


    public function user(){
        return $this->belongsTo(User::class);
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    // public function sluggable()
    // {
    //     return [
    //         'slug' => [
    //             'source' => 'title'
    //         ]
    //     ];
    // }
}

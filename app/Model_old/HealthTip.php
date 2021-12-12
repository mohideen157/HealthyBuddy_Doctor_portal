<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class HealthTip extends Model
{
	use Sluggable;
    use SluggableScopeHelpers;


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'health_tips';

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    /**
     * Get the doctor doctorProfile
     */
    public function doctorProfile()
    {
        return $this->hasOne('App\Model\Doctor\DoctorProfile', 'doctor_id', 'doctor_id');
    }
}

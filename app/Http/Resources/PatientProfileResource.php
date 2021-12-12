<?php

namespace App\Http\Resources;

use App\Helpers\Helper;
use Illuminate\Http\Resources\Json\Resource;

class PatientProfileResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'age' => Helper::age($this->dob),
            'app_image' => $this->app_image,
            'national_id' => $this->national_id,
            'height_feet' => $this->height_feet,
            'height_inch' => $this->height_inch,
            'height_cm' => $this->height_cm,
            'bmi' => $this->bmi,
            'bmi_score' => $this->bmi_score,
            'blood_group' => $this->blood_group,
            'weight_kg' => $this->weight_kg,
            'weight_pounds' => $this->weight_pounds,
            'occupation' => $this->occupation
        ];
    }
}

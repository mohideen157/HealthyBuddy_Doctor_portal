<?php

namespace App\Http\Resources;

use App\Http\Resources\PatientHealthResource;
use Illuminate\Http\Resources\Json\Resource;

class PatientDetailsResource extends Resource
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
            'Name' => $this->name,
            'Email' => $this->email,
            'Mobile' => $this->mobile_no,
            'Organisation Name' => $this->organistion->name,
            'Gender' => $this->patientProfile->gender,
            'Height(cm)' => $this->patientProfile->height_cm,
            'Weight(Kg)' => $this->patientProfile->weight_kg,
            'BMI' => $this->patientProfile->bmi,
            'Blood Group' => $this->patientProfile->blood_group,
            'Occupation' => $this->patientProfile->occupation,
            'Date Of Birth' => $this->patientProfile->dob,
            'National Id Proof' => $this->patientProfile->national_id,
            'Patient Health Profile' => PatientHealthResource::collection($this->patientHealthProfile)

        ];
    }
}

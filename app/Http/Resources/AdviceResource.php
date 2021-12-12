<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class AdviceResource extends Resource
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
            'id' => $this->id,
            'type' => ($this->type == 1) ? 'Diet Advise' : 'Excersice Advise',
            'description' => $this->description,
            'date' => $this->created_at->toDateTimeString(),
            'doctor' => [
                'name' => $this->doctor->name,
                'mobile' => $this->doctor->mobile_no,
                'email' => $this->doctor->email
            ]
        ];
    }
}

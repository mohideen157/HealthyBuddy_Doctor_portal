<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;


class PatientHealthResource extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
           'Parent Question' => $this->parent_key,
           'Child Question' => $this->child_key,
           'Value' => $this->value,
           'Unit' => $this->unit,
           'Active' => $this->active,
           'Extra Information' => json_decode($this->extra_info, true)
        ];
    }
}

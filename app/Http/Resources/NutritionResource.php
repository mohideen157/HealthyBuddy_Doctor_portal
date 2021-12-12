<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class NutritionResource extends Resource
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
            'extra_info' => json_decode($this->extra_info, true)
        ];
    }
}

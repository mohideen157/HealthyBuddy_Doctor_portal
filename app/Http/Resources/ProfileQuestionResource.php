<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ProfileQuestionResource extends Resource
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
            'patient_id' => $this->patient_id,
            'question_slug' => $this->question_slug,
            'answer' => $this->answer
        ];
    }
}

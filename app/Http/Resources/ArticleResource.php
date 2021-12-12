<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ArticleResource extends Resource
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
            "title" => $this->title,
            "content" => $this->content,
            "image" => $this->image,
            "user" => [
                'name' => $this->user->name,
                'mobile' => $this->user->mobile_no,
                'email' => $this->user->email
            ],
        ];
    }
}

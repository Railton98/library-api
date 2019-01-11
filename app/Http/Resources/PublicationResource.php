<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class PublicationResource extends Resource
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
            'title' => $this->title,
            'author' => $this->author,
            'image' => $this->image,
            'type' => $this->type,
            'publication_year' => $this->publication_year,
            'short_description' => $this->short_description,
            'full_description' => $this->full_description,
            'count_exemplaries' => $this->exemplaries->count(),
            'exemplaries' => $this->exemplaries
        ];
    }
}

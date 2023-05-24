<?php

namespace App\Http\Resources\API\Audio;

use Illuminate\Http\Resources\Json\JsonResource;

class AudioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'audio_id' => $this->audio_id,
            'category_name' => optional($this->categoryName)->name,
            'subcategory_name' => optional($this->subCategoryName)->name,
            'author_name' => optional($this->getAuthor)->name,
            'title' => $this->title,
            'description' => strip_tags($this->description),
            'duration' => $this->duration,
            'type' => $this->type,
            'keywords' => $this->keywords,
            'cover_image' => getSingleMedia($this, 'cover_image', null),
            'audio_file_path' => getSingleMedia($this, 'audio_file_path', null),
        ];
    }
}

<?php

namespace App\Http\Resources\API\Author;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
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
            'author_id' => $this->author_id,
            'name' => $this->name,
            'education' => $this->education,
            'description' => strip_tags($this->description),
            'designation' => $this->designation,
            'mobile_no' => $this->mobile_no,
            'email_id' => $this->email_id,
            'address' => $this->address,
            'image' => getSingleMedia($this,'profile_image',null),
            'status' => $this->status
        ];
    }
}

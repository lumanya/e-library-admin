<?php

namespace App\Http\Resources\API\Book;

use Illuminate\Http\Resources\Json\JsonResource;

class BookRatingResource extends JsonResource
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
            'user_id'=> $this->user_id,
            'rating_id' => $this->rating_id,
            'rating' => $this->rating,
            'review'=>$this->review,
            'created_at'=> date('Y-m-d', strtotime($this->created_at)),
            'user_name'=>optional($this->getUsername)->name,
            'profile_image'=> getSingleMedia($this->getUsername, 'profile_image',null),
            'created_at'=> date('Y-m-d',strtotime($this->created_at))
        ];
    }
}

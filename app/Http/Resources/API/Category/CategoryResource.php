<?php

namespace App\Http\Resources\API\Category;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'category_id' => $this->category_id,
            'name' => $this->name,
            'status'=>$this->status,
            'total_book'=>2,
        ];
    }
}

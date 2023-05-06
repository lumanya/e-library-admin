<?php

namespace App\Http\Resources\API\SubCategory;

use Illuminate\Http\Resources\Json\JsonResource;

class SubCategoryResource extends JsonResource
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
            'subcategory_id'=>$this->subcategory_id,
            'category_id' => $this->category_id,
            'name' => $this->name,
            'status'=>$this->status,
        ];
    }
}

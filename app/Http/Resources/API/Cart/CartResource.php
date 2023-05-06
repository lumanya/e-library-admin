<?php

namespace App\Http\Resources\API\Cart;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
            'cart_mapping_id' => $this->cart_mapping_id,
            'book_id'=>$this->book_id,
            'name' => $this->getBook->name,
            'title' => $this->getBook->title,
            'front_cover'=>getSingleMedia($this->getBook, 'front_cover',null),
            'author_name' => $this->getBook->getAuthor->name,
            'price'=>$this->getBook->price,
            'discount'=>$this->getBook->discount,
            'discounted_price'=>$this->getBook->discounted_price
        ];
    }
}

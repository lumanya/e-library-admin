<?php

namespace App\Http\Resources\API\Book;

use Illuminate\Http\Resources\Json\JsonResource;

class TopSellBookResource extends JsonResource
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
            'book_id'=>$this->book_id,
            'category_name' => $this->categoryName->name,
            'subcategory_name' => $this->subCategoryName->name,
            'author_name'=>$this->getAuthor->name,
            'name'=>$this->name,
            'title'=> $this->title,
            'topic_cover'=>$this->topic_cover,
            'description'=>strip_tags($this->description),
            'format'=>$this->format,
            'edition'=>$this->edition,
            'keywords'=>$this->keywords,
            'language'=>$this->language,
            'publisher'=>$this->publisher,
            'date_of_publication'=>$this->date_of_publication,
            'front_cover'=>getSingleMedia($this, 'front_cover',null),
            'back_cover'=>getSingleMedia($this, 'back_cover',null),
            'file_path'=> getSingleMedia($this, 'file_path',null),
            'file_sample_path'=>getSingleMedia($this, 'file_sample_path',null),
            'price'=>$this->price,
            'discount'=>$this->discount,
            'discounted_price'=>$this->discounted_price,
            'rating'=> $this->rating,

            'is_wishlist_book'=>$this->is_wishlist,
        ];
    }
}

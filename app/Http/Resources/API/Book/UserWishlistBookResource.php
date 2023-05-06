<?php

namespace App\Http\Resources\API\Book;

use Illuminate\Http\Resources\Json\JsonResource;

class UserWishlistBookResource extends JsonResource
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
            'category_name' => isset($this->getBook->categoryName) ? $this->getBook->categoryName->name : null,
            'subcategory_name' => isset($this->getBook->subCategoryName) ? $this->getBook->subCategoryName->name : null,
            'author_name'=> isset($this->getBook->getAuthor->name) ? $this->getBook->getAuthor->name : null,
            'name'=>$this->getBook->name,
            'title'=> $this->getBook->title,
            'topic_cover'=>$this->getBook->topic_cover,
            'description'=>strip_tags($this->getBook->description),
            'format'=>$this->getBook->format,
            'edition'=>$this->getBook->edition,
            'keywords'=>$this->getBook->keywords,
            'language'=>$this->getBook->language,
            'publisher'=>$this->getBook->publisher,
            'date_of_publication'=>$this->getBook->date_of_publication,
            'front_cover'=>getSingleMedia($this->getBook, 'front_cover',null),
            'back_cover'=>getSingleMedia($this->getBook, 'back_cover',null),
            'file_path'=> getSingleMedia($this->getBook, 'file_path',null),
            'file_sample_path'=>getSingleMedia($this->getBook, 'file_sample_path',null),
            'price'=>$this->getBook->price,
            'discount'=>$this->getBook->discount,
            'discounted_price'=>$this->getBook->discounted_price,
            'is_wishlist'=>1
        ];
    }
}

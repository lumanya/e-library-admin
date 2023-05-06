<?php

namespace App\Http\Resources\API\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserPurchasedBookResource extends JsonResource
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
            'book_id' =>$this->getBook->book_id,
            'category_name' => $this->getBook->categoryName->name,
            'subcategory_name' => $this->getBook->subCategoryName->name,
            'author_name'=>$this->getBook->getAuthor->name,
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
        ];
    }
}

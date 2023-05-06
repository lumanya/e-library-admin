<?php

namespace App\Http\Resources\API\Book;

use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\MediaLibrary\Conversion\Conversion;
use Spatie\MediaLibrary\Conversion\ConversionCollection;

class MobileSliderResource extends JsonResource
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
            'mobile_slider_id'=>$this->mobile_slider_id,
            'title'=>$this->title,
            'slide_image'=>getSingleMedia($this, 'slide_image',null),
            'link'=>$this->link,
        ];
    }
}

<?php

namespace App\Http\Resources\API\Transaction;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'book_id'=>$this->getBook->book_id,
            'book_name'=>$this->getBook->name,
            'book_title'=>$this->getBook->title,
            'front_cover'=>getSingleMedia($this->getBook, 'front_cover',null),
            'price' => isset($this->price) ? $this->price : $this->getBook->price,
            'discount' => isset($this->discount) ? $this->discount : $this->getBook->discount,
            'total_amount' => $this->getTransaction->total_amount,
            'payment_type' => $this->getTransaction->payment_type,
            'txn_id'=>"Txn Id ".$this->getTransaction->txn_id,
            'payment_status'=>$this->getTransaction->payment_status,
            'other_transaction_detail'=>$this->getTransaction->other_transaction_detail,
            'datetime'=>$this->getTransaction->datetime,
        ];
    }
}
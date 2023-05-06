<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionDetail extends Model
{
    protected $table="transactions_detail";
    protected $primaryKey='sales_detail_id';
    protected $fillable=['transaction_id','book_id' ,'user_id' ,'price' ,'discount'];
    protected $casts = [
        'transaction_id'   => 'integer',
        'book_id'   => 'integer',
        'user_id'   => 'integer',
        'price'  => 'double',
        'discount'  => 'double',
      
    ];
    use SoftDeletes;

    public function getBook(){
        return $this->belongsTo(Book::class, 'book_id','book_id')->with(['getAuthor']);
    }

    public function getUser(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getTransaction(){
        return $this->belongsTo(Transaction::class, 'transaction_id','transaction_id');
    }
}

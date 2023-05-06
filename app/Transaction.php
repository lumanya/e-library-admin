<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;
    protected $table="transactions";
    protected $primaryKey='transaction_id';
    protected $fillable=['user_id','datetime' ,'total_amount', 'discount','payment_type','txn_id','payment_status','other_transaction_detail'];
    protected $casts = [
        'user_id'   => 'integer',
        'payment_type'   => 'integer',
         'discount'  => 'double',
        'total_amount'  => 'double',
      
    ];

    protected function  getUserPurchaseBook($user_id , $book_id){
        // $data = Transaction::where('transaction_detail->STATUS','TXN_SUCCESS')->where('user_id',$user_id)->where('book_id',$book_id)->first();
        $data = Transaction::whereIn('status',[0,1])->where('user_id',$user_id)->where('book_id',$book_id)->first();

        return ($data != null) ? 1 : 0;
    }

    public function getUser(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getTransactionDetail(){
        return $this->hasMany(TransactionDetail::class, 'transaction_id')->with(['getUser']);
    }

    public function getSingleTransactionDetail(){
        return $this->hasOne(TransactionDetail::class, 'transaction_id')->with('getUser');
    }
}

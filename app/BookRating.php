<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookRating extends Model
{
    protected $table = "book_rating";
    protected $primaryKey = "rating_id";
    protected $fillable = ['book_id','user_id','rating', 'review'];
    protected $casts = [
        'book_id'  => 'integer',
        'user_id'  => 'integer',
        'rating'   => 'double',

          
    ];



    public function getUsername()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getBookname()
    {
        return $this->belongsTo(Book::class, 'book_id');
    } 
}

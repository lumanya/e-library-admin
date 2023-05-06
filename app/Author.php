<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// use Spatie\MediaLibrary\HasMedia\HasMedia;
// use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Author extends Model implements HasMedia
{
    use InteractsWithMedia;
    use SoftDeletes;
    protected $table="author";

    public $primaryKey='author_id';

    public $fillable=['name','education','description','designation','mobile','email','address'];
    public $timestamp=true;

    public function getBooks(){
        return $this->hasMany(Book::class, 'author_id');
    }
    public function getBookRating(){
        // return $this->hasManyThrough('App\BookRating', 'App\Book','book_id','book_id','author_id','author_id');
        return $this->hasManyThrough('App\BookRating', 'App\Book', 'author_id' , 'book_id','author_id','book_id');
    }
}

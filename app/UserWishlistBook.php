<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Spatie\MediaLibrary\Models\Media;
// use Spatie\MediaLibrary\HasMedia\HasMedia;
// use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class UserWishlistBook extends Model  implements HasMedia
{
    // use HasMediaTrait;
    use InteractsWithMedia;
    
    protected $table = "user_wishlist_book";
    protected $primaryKey = "wishlist_id";
    protected $fillable = ['book_id','user_id','is_wishlist'];
    protected $casts = [
        'book_id'   => 'integer',
        'user_id'   => 'integer',
        'is_wishlist'   => 'integer',
        
        
      
    ];


    protected function getWishlistBook($book_id,$user_id){
        return self::where('book_id',$book_id)->where('user_id',$user_id)->first();
    }

    public function getBook(){
        return $this->belongsTo(Book::class, 'book_id','book_id')->with(['getAuthor','categoryName','subCategoryName']);
    }
}

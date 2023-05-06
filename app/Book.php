<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Book extends Model implements HasMedia
{
    use InteractsWithMedia;
    //book model
    // use SoftDeletes;
    protected $table="book";
    protected $primaryKey='book_id';
    protected $fillable=['category_id','subcategory_id','keywords','author_id','name','title','description','edition','keywords','language','publisher','date_of_publication','front_cover','back_cover','file_path','file_sample_path','format','status','check_mark','page_count','price','in_stock','flag_top_sell','flag_recommend','discount','discounted_price'
];
protected $casts = [
    'category_id'  => 'integer',
    'subcategory_id' =>'integer',
    'author_id' =>'integer',
    'page_count'=>'integer',
    'in_stock'=>'integer',
    'price'=>'double',
    'discount'=>'double',
    'discounted_price'=>'double',   
];

    public function categoryName(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    
    public function subCategoryName(){
        return $this->belongsTo(SubCategory::class, 'subcategory_id')->withDefault([
            'name' => ""
        ]);
    }

    public function getBookRating(){
        return $this->hasMany(BookRating::class, 'book_id')->with(['getUsername']);
    }

    public function getAuthor(){
        return $this->belongsTo(Author::class, 'author_id');
    }

    public function getBookLanguage(){
        return $this->belongsTo(StaticData::class,'language','id');
    }

    public function getAuthorBookList(){
        return $this->hasMany(Book::class, 'author_id','author_id');
    }

    public function getCategoryBookList(){
        return $this->hasMany(Book::class, 'category_id','category_id');
    }

    public function getWishList(){
        return $this->hasMany(UserWishlistBook::class, 'book_id','book_id');
    }

    public function getPurchase(){
        return $this->hasMany(TransactionDetail::class, 'book_id','book_id')->whereHas('getTransaction',function ($q){
            $q->whereIn('payment_status',['TXN_SUCCESS','approved']);
        });
    }

    public function getAuthors(){
        return $this->hasMany(Author::class, 'author_id','author_id');
    }

    public function getUserBookRating(){
        // if(\Auth::user() != null){
        //     return $this->hasOne(BookRating::class, 'book_id')->filter('user_id',\Auth::user()->id);
        // }
        return null;
    }

}

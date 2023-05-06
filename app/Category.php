<?php

namespace App;
use App\Book;
use App\SubCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Category extends Model
{
    use SoftDeletes;
    protected $table = "category";
    protected $primaryKey = "category_id";
    protected $softDelete = true;
    protected $fillable = ['name'];

    public function getcategory(){
        return $this->belongsTo(Category::class, 'parent_id');
    }
    
    protected function getCategoryName($category_id){
        return self::where('category_id',$category_id)->first();
       
    }

    public function book(){
        return $this->hasMany('App\Book', 'category_id');
    }

    public function subcategories(){
        return $this->hasMany('App\SubCategory', 'category_id');
    }
}

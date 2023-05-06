<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class SubCategory extends Model
{
    use SoftDeletes;
    protected $table = "sub_category";
    protected $primaryKey = "subcategory_id";
    protected $softDelete = true;
    protected $fillable = ['name','category_id'];
    protected $casts = [
        'category_id'   => 'integer',
    
    ];

    public function getcategory(){
        return $this->belongsTo(Category::class, 'category_id');
    }
   
    protected function getSubCategoryName($subcategory_id){
        return self::where('subcategory_id',$subcategory_id)->first();       
    }
    
    protected function getCategoryWiseSubCategory($category_id){
        return self::where('category_id',$category_id)->get();
    }
}

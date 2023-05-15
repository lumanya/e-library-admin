<?php

namespace App;

use Illuminate\Console\Concerns\InteractsWithIO;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Audio extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use SoftDeletes;

    protected $table = 'audio';

    public $primaryKey = 'audio_id';

    protected $fillable = [
        'title',
        'description',
        'keywords',
        'duration',
        'type',
        'cover_image',
        'audio_file_path',
        'category_id',
        'subcategory_id',
        'author_id',
        'like_count',
        'view_count',
    ];

    protected $casts = [
        'category_id'  => 'integer',
        'subcategory_id' =>'integer',
        'author_id' => 'integer',
        'like_count'=> 'integer',
        'view_count' => 'integer',
    ];

    public function categoryName(){
        return $this->belongsTo(Category::class, 'category_id');
    }


    public function subCategoryName(){
        return $this->belongsTo(SubCategory::class, 'subcategory_id')->withDefault([
            'name' => ""
        ]);
    }

    public function getAuthor(){
        return $this->belongsTo(Author::class, 'author_id');
    }

    public function getAuthors(){
        return $this->hasMany(Author::class, 'author_id','author_id');
    }
}

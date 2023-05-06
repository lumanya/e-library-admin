<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feedback extends Model
{
    use SoftDeletes;
    protected $table="feedback";
    protected $primaryKey = 'feedback_id';
    protected $fillable = ['name','email','comment'];
}

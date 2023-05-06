<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = "settings";
    protected $primaryKey = "id";
    protected $fillable = ['type','key','value'];
    public $timestamps = false;


    protected $casts = [
        'type' => 'string',
        'key'   => 'string',
        'value' => 'string',
    ];
}

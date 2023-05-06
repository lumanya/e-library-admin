<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VerificationCode extends Model
{
    protected $table = "verification_code";
    protected $primaryKey = "id";
    protected $fillable = ['user_id','code','date','time'];
    protected $casts = [
        'user_id'   => 'integer',
        'code'   => 'integer',
      ];
}

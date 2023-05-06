<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailTemplate extends Model
{
    protected $table = "mail_template";
    protected $primaryKey = "mail_id";
    protected $fillable = ['mail_template_id','mail_subject','mail_body','mail_footer'];
    
    protected $casts = [
        'mail_template_id'   => 'integer',
        
      
      
    ];
}

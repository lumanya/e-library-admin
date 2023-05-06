<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\InteractsWithMedia;


class AppSetting extends Model implements HasMedia

{
    
    use InteractsWithMedia;
 
    public $table="app_setting";
    public $primaryKey='id';
    public $fillable=[
        'site_name', 'site_email', 'site_logo', 'site_favicon', 'site_description', 'google_map_api', 'site_header_code', 'site_footer_code', 'site_copyright', 'contact_title', 'contact_address', 'contact_email', 'contact_number', 'facebook_url', 'instagram_url', 'twitter_url', 'gplus_url', 'linkedin_url', 'slider_title', 'slider_image', 'slider_status', 'remember_token'
    ];
    
    public $timestamps=false;
}

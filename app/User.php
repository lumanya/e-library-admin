<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Authenticatable implements HasMedia 

{
    //  use HasApiTokens ,Notifiable ,InteractsWithMedia;
     use HasApiTokens, Notifiable, HasRoles, InteractsWithMedia,SoftDeletes;    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username','name', 'email', 'password','contact_number','user_type' ,'image' ,'registration_id' ,'device_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

   
    public function ratings(){
        return $this->hasMany(BookRating::class, 'user_id','id');
    }


    public function getCategoryData($id) {
        $category_data = \App\Category::where('category_id',$id)->first();
        return $category_data;
    }

    public function user_role()
    {
        return $this->hasOneThrough('App\Role', 'App\RoleUser','user_id','id','id','role_id')->withDefault([
            'name' => ''
        ]);
    }

    public function is($roleName) {
        // $auth_user=authSession();
        $role=$this->user_role;
        if(isset($role))
        {
            if ($role->name == $roleName)
            {
                return true;
            }
        }

        return false;
    }

}

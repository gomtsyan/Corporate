<?php

namespace Corp;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Str;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'login'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function articles() {
       return $this->hasMany('Corp\Article');
    }

    public function roles() {
        return $this->belongsToMany('Corp\Role','role_user');
    }

    public function canDo($permission, $requirre = false) {

        if(is_array($permission)){

            foreach($permission as $permName) {

                $permName = $this->canDo($permName);

                if($permName && !$requirre) {
                    return true;
                }elseif(!$permName && $requirre) {
                    return false;
                }

            }

            return $requirre;

        }else{

            foreach ($this->roles as $role) {
                foreach ($role->permissions as $perm) {
                    if(Str::is($permission, $perm->name)) {
                        return true;
                    }
                }
            }
        }


    }

    public function hasRole($name, $requirre = false) {

        if(is_array($name)){

            foreach($name as $roleName) {

                $roleName = $this->hasRole($roleName);

                if($roleName && !$requirre) {
                    return true;
                }elseif(!$roleName && $requirre) {
                    return false;
                }

            }

            return $requirre;

        }else{

            foreach ($this->roles as $role) {

                if($role->name == $name) {
                    return true;
                }

            }
        }


    }

}

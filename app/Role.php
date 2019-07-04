<?php

namespace Corp;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function users() {
        return $this->belongsToMany('Corp\User','role_user');
    }

    public function permissions() {
        return $this->belongsToMany('Corp\Permission','permission_role');
    }

    public function hasPermissions($name, $requirre = false) {

        if(is_array($name)){

            foreach($name as $permissionName) {

                $permissionName = $this->hasPermissions($permissionName);

                if($permissionName && !$requirre) {
                    return true;
                }elseif(!$permissionName && $requirre) {
                    return false;
                }

            }

            return $requirre;

        }else{

            foreach ($this->permissions()->get() as $permission) {

                if($permission->name == $name) {
                    return true;
                }

            }
        }

    }

    public function savePermissions($inputPermissions) {

        if(!empty($inputPermissions)) {

            $this->permissions()->sync($inputPermissions);

        }else{

            $this->permissions()->detach();

        }

        return true;

    }

}

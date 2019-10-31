<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';
    public $primaryKey = 'id';
    public $timestamps = false;

    //relationships
    public function roles(){
        return $this->belongsToMany('App\Role', 'roles_permissions', 'permission_id', 'role_id');
    }
}

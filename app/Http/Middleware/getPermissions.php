<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use User;
use Illuminate\Support\Facades\DB;

class GetPermissions
{
    public function handle($request, Closure $next)
    {
        // Get the permissions asociated with the user role.
        $user = Auth::user();
        $permissions = DB::table('roles_permissions')->join('permissions', 'roles_permissions.permission_id', '=', 'permissions.id')->select('permissions.name')->where('role_id', $user->role_id)->get()->toArray();
        //
        $request->attributes->add(['permissions'=> array_map(function($permission){
            return $permission->name;
        }, $permissions)]);
        return $next($request);
    }
}
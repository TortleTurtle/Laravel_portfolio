<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class userController extends Controller
{
    //index users
    public function index(){
        //eager loading role with the user.
        $users = User::select('id', 'name', 'email', 'role_id')->with(['role' => function ($query){
            $query->select('id','name');
        }])->get();
        $roles = Role::all();

        return view('user.userIndex',[
            'users' => $users,
            'roles' => $roles
        ]);
    }
    //search for users
    public function search(Request $request){

        $search = $request->get('search');
        $role = $request->get('role');
        $roles = Role::all();

        if(empty($search)){
            $users = User::whereHas('role', function (Builder $query) use ($role){
                $query->where('id', '=', $role);
            })->get();
        }
        elseif(empty($role)){
            $users = User::where('name', 'like', "%$search%")->get();
        }
        else{
            $users = User::where('title', 'like', "%$search%")->whereHas('role', function (Builder $query) use ($role){
                $query->where('id', '=', $role);
            })->get();
        }
        
        return view('user.userIndex',[
            'users' => $users,
            'roles' => $roles,
        ]);
    }

    //show specific user
    public function show($id){
        $user = User::select('id', 'name', 'email', 'role_id')->with(['role' => function ($query){
            $query->select('id','name');
        }])->where('id', '=', $id)->first();

        return view('user.user', [
            'user' => $user
        ]);
    }

    //edit user
    public function edit(Request $request, $id){
        $user = User::find($id);
        $roles = Role::all();
        if (Auth::user()->id == $id || in_array('editUser', $request->get('permissions'))) {
            return view('user.userEdit', [
                'user' => $user,
                'roles' => $roles
            ]);
        }
        else {
            abort(403, "You do not have the right permissions");
        }
    }

    public function update(Request $request, $id){
        $user = User::find($id);

        $user->name = $request->name;
        $user->email = $request->email;
        //check if a new role is set
        if(isset($request->role)){
            $user->role_id = $request->role;
        }

        $user->save();

        return redirect("/users/$user->id");
    }

    public function delete(Request $request , $id){
        $user = User::find($id);
        //check if user has the right permissions or is the owner of the account.
        if (in_array('deleteUser', $request->get('permissions')) || Auth::user()->id == $id){
            if (Auth::user()->id == $id){
                Auth::logout();
            }

            User::destroy($id);

            return redirect()->action('userController@index');
        }
        else {
            return abort('403', "You do not have the right permissions.");
        }
    }
}

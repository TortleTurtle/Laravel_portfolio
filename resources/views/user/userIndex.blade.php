@extends('layouts.app')

@section('title')
<title>Users</title>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg">
            <h1>Users</h1>
        </div>
    </div>
    <div class="row">
            <form action="/users/search" method="GET">
                <div class="col">
                    <label for="search">Search:</label>
                    <input type="text" name="search">
                </div>
                <div class="col">
                    <label for="role">Role:</label>
                    <select name="role">
                        <option value=''></option>
                        @foreach ($roles as $role)
                            <option value="{{$role->id}}">{{$role->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <input type="submit" class="btn btn-primary" value="submit">
                </div>
            </form>
        </div>
    <div class="row">
        <table class="table table-bordered">
            <thead>
                <th>username:</th>
                <th>role</th>
            </thead>
            @foreach ($users as $user)
                <tr>
                    <td><a href="/users/{{$user->id}}">{{$user->name}}</a></td>
                    <td>{{$user->role->name}}</td>
                </tr>
            @endforeach
        </table>
    </div>

@endsection
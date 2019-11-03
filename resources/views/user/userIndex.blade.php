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
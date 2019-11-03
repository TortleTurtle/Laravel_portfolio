@extends('layouts.app')

@section('title')
    <title>{{$user->name}}</title>
@endsection

@section('content')
<div class="d-flex flex-column align-items-center">
    <div class="p-2"><h1>{{$user->name}}</h1></div>
    <div class="p-2"><h3>Role: {{$user->role->name}}</h3></div>
    <div class="p-2"><h3>Email: {{$user->email}}</h3></div>
    @if (!(Auth::guest()))
        @if (Auth::user()->name = $user->name || Auth::user()->role->name == 'Admin')
            <div class="p-2">
                <a href="/users/{{$user->id}}/edit" class='btn btn-primary'>Edit profile</a>
                <form action="/users/{{$user->id}}" method="POST">
                    @csrf
                    @method("DELETE")
                    <input type="submit" value="Delete" class="btn btn-danger">
                </form>
            </div>
        @endif
    @endif
</div>
@endsection
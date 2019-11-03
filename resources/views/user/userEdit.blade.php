@extends('layouts.app')

@section('title')
    <title>{{$user->name}}</title>
@endsection

@section('content')
<form action="/users/{{$user->id}}" method="POST">
    @csrf
    @method("PUT")
<div class="d-flex flex-column align-items-center">
    <div class="p-2">
        <label for="name">Name:</label>
        <input type="text" name="name" value="{{$user->name}}" required>
    </div>
    <div class="p-2">
        <label for="email">Email:</label>
        <input type="email" name="email" value="{{$user->email}}" required>
    </div>
    @if (Auth::user()->role->name == "Admin")
        <div class="p-2">
            <label for="role">Role:</label>
            <select name="role">
                @foreach ($roles as $role)
                    <option value="{{$role->id}}" @if ($role->id == $user->role->id) selected @endif >{{$role->name}}</option>
                @endforeach
            </select>
        </div>
    @endif
    <div class="p-2"><input type="submit" class='btn btn-primary'></div>
</div>
</form>
@endsection
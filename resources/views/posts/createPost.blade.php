@extends('layouts.app')

@section('content')
    <h1>Create a post</h1>
    <form action="/posts" method="POST">
        @csrf

        <div>
            <label for="slug">Slug: </label>
            @if ($errors->has('slug'))
                <p>{{$errors->first('slug')}}</p>
            @endif
        </div>
        <div><input name="slug" type="text"></div>

        <div>
            <label for="title" type="text">Title:</label>
            @if ($errors->has('title'))
                <p>{{$errors->first('title')}}</p>
            @endif
        </div>
        <div><input name="title" type="text"></div>

        <div>
            <label for="content">Content:</label>
            @if ($errors->has('content'))
                <p>{{$errors->first('content')}}</p>
            @endif
        </div>
        <div><input name="content" type="text"></div>

        <input type="submit" value="Submit">
    </form>
@endsection
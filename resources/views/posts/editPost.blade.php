@extends('layouts.app')

@section('content')
<h1>Edit a post</h1>
<form action="/posts/{{ $post->id }}" method="POST">
    @csrf
    @method('PUT')
    <div>
        <label for="slug">Slug:</label>
        @if ($errors->has('slug'))
            <p>{{$errors->first('slug')}}</p>
        @endif
    </div>
    <div><input name="slug" type="text" value="{{ $post->slug }}"></div>

    <div>
        <label for="title" type="text">Title:</label>
        @if ($errors->has('title'))
            <p>{{$errors->first('title')}}</p>
        @endif
    </div>
    <div><input name="title" type="text" value="{{ $post->title }}"></div>

    <div>
            <label for="category">Category</label>
        </div>
        <div>
            <select name="category">
                @foreach ($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="status">Category</label>
        </div>
        <div>
            <select name="status">
                @if ($post->status == 0)
                    <option value="0" selected>Inactive</option>
                    <option value="1">Active</option>
                @else
                    <option value="0">Inactive</option>
                    <option value="1" selected>Active</option>
                @endif
            </select>
        </div>

    <div>
        <label for="content">Content:</label>
        @if ($errors->has('content'))
            <p>{{$errors->first('content')}}</p>
        @endif
    </div>
    <div><input name="content" type="text" value="{{ $post->content }}"></div>
    <input type="submit" value="Submit">
</form>
@endsection
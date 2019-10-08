@extends('layouts.app')

@section('content')
<h1>Edit a post</h1>
<form action="/posts/{{ $post->id }}" method="POST">
    @csrf
    @method('PUT')
    <label for="slug">Slug:</label>
    <input name="slug" type="text" value="{{ $post->slug }}">
    <label for="title" type="text">Title:</label>
    <input name="title" type="text" value="{{ $post->title }}">
    <label for="content">Content:</label>
    <input name="content" type="text" value="{{ $post->content }}">
    <input type="submit" value="Submit">
</form>
@endsection
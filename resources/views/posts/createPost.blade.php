@extends('layouts.app')

@section('content')
    <h1>Create a post</h1>
    <form action="/posts" method="POST">
        @csrf
        <label for="slug">Slug:</label>
        <input name="slug" type="text">
        <label for="title" type="text">Title:</label>
        <input name="title" type="text">
        <label for="content">Content:</label>
        <input name="content" type="text">
        <input type="submit" value="Submit">
    </form>
@endsection
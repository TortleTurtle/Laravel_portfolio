@extends('layouts.app')
@section('title')
    <title>posts</title>
@endsection

@section('content')
<div class="row">
    <form action="/posts/search" method="GET">
        <div class="col">
            <label for="search">Search</label>
            <input type="text" name="search">
        </div>
        <div class="col">
            <label for="catagory">Catagory</label>
            <select name="catagory">
                <option value="catagory1">Catagory1</option>
                <option value="catagory2">Catagory2</option>
                <option value="catagory3">Catagory3</option>
                <option value="catagory4">Catagory4</option>
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
            <th>Title</th>
            <th>author</th>
        </thead>
        @foreach ($posts as $post)
            <tr>
                <td><a href="/posts/{{$post->slug}}">{{ $post->title}}</a></td>
                <td>{{ $post->author}}</td>
            </tr>
        @endforeach
    <table>
</div>
@endsection
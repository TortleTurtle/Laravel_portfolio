@extends('layouts.app')

@section('content')
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
@endsection
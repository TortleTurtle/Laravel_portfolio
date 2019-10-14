@extends('layouts.app')

@section('content')
<table>
    <thead>
        <th>Title</th>
        <th>author</th>
    </thead>
    @foreach ($posts as $post)
        <tr>
            <td>{{ $post->title}}</td>
            <td>{{ $post->author}}</td>
    @endforeach
<table>
@endsection
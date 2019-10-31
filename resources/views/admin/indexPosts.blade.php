@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
<div class="col-lg justify-content-center">
<table class="table table-bordered">
    <thead>
        <th>Title</th>
        <th>author</th>
        <th>edit</th>
        <th>delete</th>
        <th>toggle status</th>
    </thead>
    @foreach ($posts as $post)
        <tr>
            <td><a href="/posts/{{$post->slug}}">{{ $post->title}}</a></td>
            <td>{{ $post->author}}</td>
            <td><a href="/posts/{{$post->slug}}/edit" class="btn btn-warning">Edit</a></td>
            <td>
                <form action="/posts/{{$post->slug}}/delete" method="POST">
                @method('DELETE')
                @csrf
                <input type="submit" value="Delete" class="btn btn-danger">
                </form>
            </td>
            <td>
                <form action="/posts/toggle/{{$post->slug}}" method="POST">
                    @method('PUT')
                    @csrf
                    <input type="submit" @if($post->status == 0) value="inactive" class="btn btn-secondary" @else value="active" class="btn btn-primary" @endif>
                </form>
        </tr>
    @endforeach
    </table>
</div>
</div>
@endsection
@extends ('layouts.app')

@section('content')
    <h1>{{ $post->title}}</h1>
    <h2>{{ $post->content}}</h2>
@endsection
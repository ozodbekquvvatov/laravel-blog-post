@extends('layout.app')
@section('title','Show Post')

@section('content')

    <div class="container mt-5">
        <h1 class="text-center post-header mb-4">{{ $post->name }}</h1>
        <h1 class="text-center">{{ $post->body }}</h1>

        @if ($post->image)
            <img class="img-preview" src="{{ asset('storage/' . $post->image) }}" width="300" alt="Post Image">
        @else
            <p class="text-center text-muted">Rasm yo'q</p>
        @endif

        <div class="post-details text-center">
            <h1 class="created-updated">Created At: {{ $post->created_at->format('Y-m-d H:i') }}</h1>
            <h1 class="created-updated">Updated At: {{ $post->updated_at->format('Y-m-d H:i') }}</h1>
        </div>

        <!-- Back to Index Button -->
        <div class="text-center back-btn">
            <a href="{{ route('posts.index') }}" class="btn btn-primary">Back</a>
        </div>
    </div>
@endsection
   
@section('styles')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">

@endsection
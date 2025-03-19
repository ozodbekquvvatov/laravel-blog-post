@extends('layout.app')
@section('title','Posts')

@section('content')
    <div class="container mt-5">
        <h1 class="text-center">Post CRUD</h1>
        <div class="row">
            <div class="col-md-12">
                <a href="{{ route('posts.create') }}" class="btn btn-primary mb-3">Add New Post</a>
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Body</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @if (isset($posts) && count($posts) > 0)
                            @foreach ($posts as $post)
                                <tr>
                                    <td>{{ $post->id }}</td>
                                    <td>{{ $post->name }}</td>
                                    <td>{{ $post->body }}</td>
                                    <td> @if ($post->image) <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" style="width:60px; height:auto;">@endif</td>
                                    <td>
                                        <a href="{{ route('posts.show', $post->id) }}" class="btn btn-info btn-sm">Show</a>
                                        <a href="{{ route('posts.edit', $post->id) }}"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <p style="color: red" class="">Mahsulotlar mavjud emas!</p>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

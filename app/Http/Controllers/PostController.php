<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        return view('index', compact('posts'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $post = new Post();
        $post->name = $request->name;
        $post->body = $request->body;

    
        if ($request->hasFile('image')) {
            $file = $request->file('image');
    
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            $filePath = $file->storeAs('images', $fileName, 'public');
    
            $post->image = $filePath;
        }
    
        $post->save();
    
        return redirect()->route('posts.index');
    }
    
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = Post::findOrFail($id); 
        return view('show', compact('post'));
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('edit', compact('post'));
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
{

    $post->name = $request->name;
    $post->body = $request->body;


    if ($request->hasFile('image')) {
        if ($post->image) {
            $imagePath = storage_path('app/public/' . $post->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $file = $request->file('image');
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('images', $fileName, 'public');

        $post->image = $filePath;
    }

    $post->save();

    return redirect()->route('posts.index')->with('success', 'Post muvaffaqiyatli yangilandi!');
}

     
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);

    if ($post->image) {
        $imagePath = storage_path('app/public/' . $post->image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }
    $post->delete();
    return redirect()->route('posts.index');
}

}



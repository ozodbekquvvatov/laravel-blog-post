<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreUpdateRequest;

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
    
            // Fayl nomini unique qilish
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            // Faylni public/images papkasiga saqlash
            $filePath = $file->storeAs('images', $fileName, 'public');
    
            // Fayl yo‘lini bazaga saqlash
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
        $post = Post::findOrFail($id); // ID bo‘yicha postni topish
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
    public function update(StoreUpdateRequest $request, Post $post)
{
    // Kiruvchi ma'lumotlarni tekshirish

    $post->name = $request->name;
    $post->body = $request->body;

    if ($request->hasFile('image')) {
        // Eski rasmni o‘chirish
        if ($post->image) {
            $imagePath = storage_path('app/public/' . $post->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Yangi faylni yuklash
        $file = $request->file('image');
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('images', $fileName, 'public');

        // Yangi rasmni bazaga yozish
        $post->image = $filePath;
    }

    // POSTNI **HAR QANDAY HOLATDA** SAQLASH
    $post->save();

    return redirect()->route('posts.index')->with('success', 'Post muvaffaqiyatli yangilandi!');
}

     
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);

    // Agar postga bog‘langan rasm bo‘lsa, uni o‘chirish
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



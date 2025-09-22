<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'categories'])->orderByDesc('post_id')->paginate(10);
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::orderBy('category_name')->get();
        return view('posts.create', compact('categories'));
    }

    public function show(Post $post)
    {
        $post->load(['user', 'categories']);
        return view('posts.show', compact('post'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:posts,slug',
            'content' => 'required|string',
            'categories' => 'array',
            'categories.*' => 'integer|exists:categories,category_id',
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
            $base = $data['slug'];
            $i = 1;
            while (Post::where('slug', $data['slug'])->exists()) {
                $data['slug'] = $base.'-'.($i++);
            }
        }

        $data['user_id'] = Auth::id();
        $post = Post::create($data);

        if ($request->filled('categories')) {
            $post->categories()->sync($request->input('categories'));
        }

        return redirect()->route('posts.index')->with('success', 'Post created');
    }

    public function edit(Post $post)
    {
        $categories = Category::orderBy('category_name')->get();
        // Ambil id kategori yang sudah terpilih
        $selectedCategories = $post->categories()->pluck('categories.category_id')->toArray();
        return view('posts.edit', compact('post', 'categories', 'selectedCategories'));
    }

    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:posts,slug,'.$post->post_id.',post_id',
            'content' => 'required|string',
            'categories' => 'array',
            'categories.*' => 'integer|exists:categories,category_id',
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
            $base = $data['slug'];
            $i = 1;
            while (Post::where('slug', $data['slug'])->where('post_id', '!=', $post->post_id)->exists()) {
                $data['slug'] = $base.'-'.($i++);
            }
        }

        $post->update($data);
        $post->categories()->sync($request->input('categories', []));

        return redirect()->route('posts.index')->with('success', 'Post updated');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted');
    }
}
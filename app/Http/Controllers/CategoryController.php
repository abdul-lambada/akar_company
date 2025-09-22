<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderByDesc('category_id')->paginate(10);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['category_name']);
            // pastikan unik
            $base = $data['slug'];
            $i = 1;
            while (Category::where('slug', $data['slug'])->exists()) {
                $data['slug'] = $base.'-'.($i++);
            }
        }

        Category::create($data);
        return redirect()->route('categories.index')->with('success', 'Category created');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'category_name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug,'.$category->category_id.',category_id',
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['category_name']);
            $base = $data['slug'];
            $i = 1;
            while (Category::where('slug', $data['slug'])->where('category_id', '!=', $category->category_id)->exists()) {
                $data['slug'] = $base.'-'.($i++);
            }
        }

        $category->update($data);
        return redirect()->route('categories.index')->with('success', 'Category updated');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted');
    }

    public function show(Category $category)
    {
        // optionally load posts count
        $category->loadCount('posts');
        return view('categories.show', compact('category'));
    }
}
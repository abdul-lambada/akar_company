<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::with('portfolio')->orderByDesc('testimonial_id')->paginate(10);
        return view('testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        $projects = Portfolio::orderBy('project_title')->get();
        return view('testimonials.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'client_name' => 'required|string|max:255',
            'testimonial_text' => 'required|string',
            'project_id' => 'required|integer|exists:portfolio,project_id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('uploads/testimonials', 'public');
        }

        Testimonial::create($data);
        return redirect()->route('testimonials.index')->with('success', 'Testimonial created');
    }

    public function edit(Testimonial $testimonial)
    {
        $projects = Portfolio::orderBy('project_title')->get();
        return view('testimonials.edit', compact('testimonial', 'projects'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $data = $request->validate([
            'client_name' => 'required|string|max:255',
            'testimonial_text' => 'required|string',
            'project_id' => 'required|integer|exists:portfolio,project_id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        if ($request->hasFile('image')) {
            // Hapus file lama jika ada
            if (!empty($testimonial->image_path)) {
                Storage::disk('public')->delete($testimonial->image_path);
            }
            $data['image_path'] = $request->file('image')->store('uploads/testimonials', 'public');
        }

        $testimonial->update($data);
        return redirect()->route('testimonials.index')->with('success', 'Testimonial updated');
    }

    public function destroy(Testimonial $testimonial)
    {
        // Hapus file gambar dari storage jika ada
        if (!empty($testimonial->image_path)) {
            Storage::disk('public')->delete($testimonial->image_path);
        }
        $testimonial->delete();
        return redirect()->route('testimonials.index')->with('success', 'Testimonial deleted');
    }

    public function show(Testimonial $testimonial)
    {
        $testimonial->load('portfolio');
        return view('testimonials.show', compact('testimonial'));
    }
}
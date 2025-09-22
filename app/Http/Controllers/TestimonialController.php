<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\Testimonial;
use Illuminate\Http\Request;

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
        ]);

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
        ]);

        $testimonial->update($data);
        return redirect()->route('testimonials.index')->with('success', 'Testimonial updated');
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return redirect()->route('testimonials.index')->with('success', 'Testimonial deleted');
    }
}
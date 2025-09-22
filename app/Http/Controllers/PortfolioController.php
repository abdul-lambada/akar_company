<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\PortfolioImage;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    public function index()
    {
        $projects = Portfolio::with(['services', 'images'])->orderByDesc('project_id')->paginate(10);
        return view('portfolio.index', compact('projects'));
    }

    public function create()
    {
        $services = Service::orderBy('service_name')->get();
        return view('portfolio.create', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_title' => 'required|string|max:255',
            'client_name' => 'required|string|max:255',
            'service_ids' => 'array',
            'service_ids.*' => 'integer|exists:services,service_id',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $project = Portfolio::create([
            'project_title' => $validated['project_title'],
            'client_name' => $validated['client_name'],
        ]);

        $project->services()->sync($validated['service_ids'] ?? []);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                if (!$file) continue;
                $path = $file->store('uploads/portfolio', 'public');
                PortfolioImage::create([
                    'project_id' => $project->project_id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('portfolio.index')->with('success', 'Portfolio created successfully.');
    }

    public function edit(Portfolio $portfolio)
    {
        $services = Service::orderBy('service_name')->get();
        $selectedServices = $portfolio->services()->pluck('services.service_id')->toArray();
        return view('portfolio.edit', [
            'portfolio' => $portfolio,
            'services' => $services,
            'selectedServices' => $selectedServices,
        ]);
    }

    public function update(Request $request, Portfolio $portfolio)
    {
        $validated = $request->validate([
            'project_title' => 'required|string|max:255',
            'client_name' => 'required|string|max:255',
            'service_ids' => 'array',
            'service_ids.*' => 'integer|exists:services,service_id',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $portfolio->update([
            'project_title' => $validated['project_title'],
            'client_name' => $validated['client_name'],
        ]);

        $portfolio->services()->sync($validated['service_ids'] ?? []);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                if (!$file) continue;
                $path = $file->store('uploads/portfolio', 'public');
                PortfolioImage::create([
                    'project_id' => $portfolio->project_id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('portfolio.index')->with('success', 'Portfolio updated successfully.');
    }

    public function destroy(Portfolio $portfolio)
    {
        // Hapus gambar fisik terlebih dahulu
        $portfolio->loadMissing('images');
        foreach ($portfolio->images as $img) {
            if (!empty($img->image_path) && Storage::disk('public')->exists($img->image_path)) {
                Storage::disk('public')->delete($img->image_path);
            }
        }
        $portfolio->images()->delete();

        $portfolio->services()->detach();
        $portfolio->delete();
        return redirect()->route('portfolio.index')->with('success', 'Portfolio deleted successfully.');
    }

    public function show(Portfolio $portfolio)
    {
        $portfolio->load(['services', 'testimonials', 'images']);
        return view('portfolio.show', compact('portfolio'));
    }
}
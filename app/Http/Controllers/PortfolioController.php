<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\Service;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index()
    {
        $projects = Portfolio::with('services')->orderByDesc('project_id')->paginate(10);
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
        ]);

        $project = Portfolio::create([
            'project_title' => $validated['project_title'],
            'client_name' => $validated['client_name'],
        ]);

        $project->services()->sync($validated['service_ids'] ?? []);

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
        ]);

        $portfolio->update([
            'project_title' => $validated['project_title'],
            'client_name' => $validated['client_name'],
        ]);

        $portfolio->services()->sync($validated['service_ids'] ?? []);

        return redirect()->route('portfolio.index')->with('success', 'Portfolio updated successfully.');
    }

    public function destroy(Portfolio $portfolio)
    {
        $portfolio->services()->detach();
        $portfolio->delete();
        return redirect()->route('portfolio.index')->with('success', 'Portfolio deleted successfully.');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderByDesc('service_id')->paginate(10);
        return view('services.index', compact('services'));
    }

    public function create()
    {
        return view('services.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'service_name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:services,slug',
            'price' => 'required|numeric|min:0',
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['service_name']);
            $base = $data['slug'];
            $i = 1;
            while (Service::where('slug', $data['slug'])->exists()) {
                $data['slug'] = $base.'-'.($i++);
            }
        }

        Service::create($data);
        return redirect()->route('services.index')->with('success', 'Service created');
    }

    public function edit(Service $service)
    {
        return view('services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'service_name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:services,slug,'.$service->service_id.',service_id',
            'price' => 'required|numeric|min:0',
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['service_name']);
            $base = $data['slug'];
            $i = 1;
            while (Service::where('slug', $data['slug'])->where('service_id', '!=', $service->service_id)->exists()) {
                $data['slug'] = $base.'-'.($i++);
            }
        }

        $service->update($data);
        return redirect()->route('services.index')->with('success', 'Service updated');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('services.index')->with('success', 'Service deleted');
    }

    public function show(Service $service)
    {
        $service->loadCount(['portfolios']);
        return view('services.show', compact('service'));
    }
}
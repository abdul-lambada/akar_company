<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Portfolio;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function home()
    {
        $services = Service::orderBy('service_name')->take(6)->get();
        $projects = Portfolio::with(['images' => function($q){ $q->orderBy('id'); }])->latest()->take(6)->get();
        $testimonials = Testimonial::latest()->take(3)->get();

        return view('welcome', compact('services', 'projects', 'testimonials'));
    }

    public function services()
    {
        $services = Service::orderBy('service_name')->paginate(9);
        return view('public.services', compact('services'));
    }

    public function serviceDetail(string $slug)
    {
        $service = Service::where('slug', $slug)->firstOrFail();
        $projects = Portfolio::with(['images' => function($q){ $q->orderBy('id'); }])
            ->whereHas('services', function($q) use ($service){
                $q->where('services.service_id', $service->getKey());
            })
            ->latest()->paginate(9);

        return view('public.service-details', compact('service', 'projects'));
    }

    public function portfolio()
    {
        $projects = Portfolio::with(['images' => function($q){ $q->orderBy('id'); }, 'services'])
            ->latest()->paginate(9);
        $filters = Service::orderBy('service_name')->get();
        return view('public.portfolio', compact('projects', 'filters'));
    }

    public function portfolioDetail(Portfolio $portfolio)
    {
        $portfolio->load(['images' => function($q){ $q->orderBy('id'); }, 'services', 'testimonials']);
        return view('public.portfolio-details', ['project' => $portfolio]);
    }

    public function contact()
    {
        return view('public.contact');
    }
}
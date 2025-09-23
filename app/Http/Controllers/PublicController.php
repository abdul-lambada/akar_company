<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Portfolio;
use App\Models\Testimonial;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function home()
    {
        $services = Service::orderBy('service_name')->take(6)->get();
        $projects = Portfolio::with(['images' => function($q){ $q->orderBy('id'); }])->latest()->take(6)->get();
        $testimonials = Testimonial::latest()->take(3)->get();

        return view('public.home', compact('services', 'projects', 'testimonials'));
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

    // Halaman Tentang Kami
    public function about()
    {
        // info singkat, angka-angka, dan daftar client untuk kredibilitas
        $counters = [
            'years' => 5,
            'projects' => Portfolio::count(),
            'clients' => Client::count(),
        ];
        $clients = Client::latest()->take(8)->get();
        $team = User::orderBy('name')->take(6)->get();
        return view('public.about', compact('counters', 'clients', 'team'));
    }

    // Halaman Harga
    public function pricing()
    {
        // gunakan services sebagai paket harga dasar
        $services = Service::orderBy('price', 'desc')->orderBy('service_name')->get();
        return view('public.pricing', compact('services'));
    }

    // Halaman Tim
    public function team()
    {
        $team = User::orderBy('name')->paginate(12);
        return view('public.team', compact('team'));
    }
}
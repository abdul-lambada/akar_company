<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Portfolio;
use App\Models\Testimonial;
use App\Models\Client;
use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function home()
    {
        $services = Service::orderBy('service_name')->take(6)->get();
        $projects = Portfolio::with(['images' => function($q){ $q->orderBy('id'); }])->latest()->take(6)->get();
        $testimonials = Testimonial::latest()->take(3)->get();
        $posts = Post::with(['images','categories','user'])->latest()->take(3)->get();

        return view('public.home', compact('services', 'projects', 'testimonials', 'posts'));
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
        $serviceIds = collect((array) request()->input('service', []))
            ->filter()
            ->map(fn($v) => (int) $v)
            ->unique()
            ->values();

        $clientName = trim((string) request('client', ''));

        $projects = Portfolio::with(['images' => function($q){ $q->orderBy('id'); }, 'services'])
            // Match ANY: project tampil jika punya salah satu layanan yang dipilih
            ->when($serviceIds->isNotEmpty(), function($q) use ($serviceIds) {
                $q->whereHas('services', function($qs) use ($serviceIds) {
                    $qs->whereIn('services.service_id', $serviceIds);
                });
            })
            ->when($clientName !== '', function($q) use ($clientName) {
                $q->where('client_name', $clientName);
            })
            ->latest()->paginate(9)->withQueryString();

        $filters = Service::orderBy('service_name')->get();
        $clients = Portfolio::select('client_name')
            ->whereNotNull('client_name')
            ->distinct()
            ->orderBy('client_name')
            ->pluck('client_name');

        $activeServiceIds = $serviceIds->all();
        $activeClientName = $clientName !== '' ? $clientName : null;

        return view('public.portfolio', compact('projects', 'filters', 'activeServiceIds', 'clients', 'activeClientName'));
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
        // edited: gunakan full_name sesuai kolom pada tabel users
        $team = User::orderBy('full_name')->take(6)->get();
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
        // edited: gunakan full_name sesuai kolom pada tabel users
        $team = User::orderBy('full_name')->paginate(12);
        return view('public.team', compact('team'));
    }

    // Blog publik (listing)
    public function blog()
    {
        $posts = Post::with(['images','categories','user'])->latest()->paginate(9);
        return view('public.blog', compact('posts'));
    }

    // Detail blog berdasarkan slug
    public function blogDetail(string $slug)
    {
        $post = Post::with(['images','categories','user'])->where('slug', $slug)->firstOrFail();
        // artikel terkait (berdasarkan kategori pertama)
        $related = collect();
        if ($post->categories->count()) {
            $catIds = $post->categories->pluck('category_id');
            $related = Post::with(['images'])
                ->where('post_id', '!=', $post->post_id)
                ->whereHas('categories', function($q) use ($catIds) {
                    $q->whereIn('categories.category_id', $catIds);
                })
                ->latest()->take(3)->get();
        }
        return view('public.blog-detail', compact('post','related'));
    }

    // Pencarian konten publik
    public function search(Request $request)
    {
        $q = trim($request->get('q', ''));
        $services = collect();
        $projects = collect();
        $posts = collect();

        if ($q !== '') {
            $services = Service::where('service_name', 'like', "%{$q}%")->orderBy('service_name')->take(10)->get();
            $projects = Portfolio::with(['images'])
                ->where(function($w) use ($q){
                    $w->where('project_title', 'like', "%{$q}%")
                      ->orWhere('client_name', 'like', "%{$q}%");
                })
                ->latest()->take(10)->get();
            $posts = Post::with(['images'])
                ->where(function($w) use ($q){
                    $w->where('title', 'like', "%{$q}%")
                      ->orWhere('content', 'like', "%{$q}%");
                })
                ->latest()->take(10)->get();
        }

        return view('public.search', compact('q','services','projects','posts'));
    }
}
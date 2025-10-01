<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Portfolio;
use App\Models\Testimonial;
use App\Models\Client;
use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class PublicController extends Controller
{
    public function home()
    {
        $services = Service::orderBy('service_name')->take(6)->get();
        $pricingServices = Service::orderBy('price', 'desc')->orderBy('service_name')->get();
        $projects = Portfolio::with(['images' => function($q){ $q->orderBy('id'); }])->latest()->take(6)->get();
        $testimonials = Testimonial::latest()->take(3)->get();
        $clientTestimonials = Testimonial::latest()->take(24)->get();
        $posts = Post::with(['images','categories','user'])->latest()->take(3)->get();
        
        return view('public.home', compact('services', 'projects', 'testimonials', 'posts', 'clientTestimonials', 'pricingServices'));
    }

    public function services()
    {
        $services = Service::orderBy('service_name')->paginate(9);
        return view('public.products', compact('services'));
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

    public function about()
    {
        $counters = [
            'years' => 5,
            'projects' => Portfolio::count(),
            'clients' => Client::count(),
        ];
        $clients = Client::latest()->take(8)->get();
        $teamQuery = User::query();
        if (Schema::hasColumn('users', 'is_public')) {
            $teamQuery->where('is_public', true);
        }
        if (Schema::hasColumn('users', 'display_order')) {
            $teamQuery->orderBy('display_order');
        }
        $team = $teamQuery->orderBy('full_name')->take(6)->get();
        return view('public.about', compact('counters', 'clients', 'team'));
    }

    public function pricing()
    {
        return redirect()->route('public.index', ['showPricing' => 1]);
    }

    public function team()
    {
        $teamQuery = User::query();
        if (Schema::hasColumn('users', 'is_public')) {
            $teamQuery->where('is_public', true);
        }
        if (Schema::hasColumn('users', 'display_order')) {
            $teamQuery->orderBy('display_order');
        }
        $team = $teamQuery->orderBy('full_name')->paginate(12);
        return view('public.team', compact('team'));
    }

    public function teamDetail(string $slug)
    {
        $member = User::where('slug', $slug)->firstOrFail();

        // Related posts by this user (if relation exists)
        $posts = Post::with(['images'])
            ->where('user_id', $member->getKey())
            ->latest()->take(6)->get();

        // Build related projects via Service matching against expertise/skills keywords
        $keywords = collect([]);
        if (isset($member->expertise) && is_array($member->expertise)) {
            $keywords = $keywords->merge($member->expertise);
        }
        if (isset($member->skills) && is_array($member->skills)) {
            $keywords = $keywords->merge($member->skills);
        }
        $keywords = $keywords->filter(fn($v) => is_string($v) && trim($v) !== '')
            ->map(fn($v) => trim($v))
            ->unique()
            ->values();

        $serviceIds = collect();
        if ($keywords->isNotEmpty()) {
            $serviceIds = Service::where(function($q) use ($keywords){
                    foreach ($keywords as $kw) {
                        $q->orWhere('service_name', 'like', "%".$kw."%");
                    }
                })
                ->pluck('service_id');
        }

        if ($serviceIds->isNotEmpty()) {
            $projects = Portfolio::with(['images','services'])
                ->whereHas('services', function($q) use ($serviceIds){
                    $q->whereIn('services.service_id', $serviceIds);
                })
                ->latest()
                ->take(6)
                ->get();
        } else {
            // Fallback if no matching services found
            $projects = Portfolio::with(['images'])->latest()->take(6)->get();
        }

        return view('public.team-detail', compact('member', 'posts', 'projects'));
    }

    public function blog()
    {
        $posts = Post::with(['images','categories','user'])->latest()->paginate(9);
        return view('public.blog', compact('posts'));
    }

    public function blogDetail(string $slug)
    {
        $post = Post::with(['images','categories','user'])->where('slug', $slug)->firstOrFail();
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

    public function contactSubmit(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:100'],
            'email' => ['required','email','max:150'],
            'subject' => ['required','string','max:150'],
            'message' => ['required','string','max:5000'],
        ]);

        Log::info('Public contact form submitted', [
            'name' => $data['name'],
            'email' => $data['email'],
            'subject' => $data['subject'],
        ]);

        return back()->with('success', 'Terima kasih! Pesan Anda telah kami terima.');
    }
}
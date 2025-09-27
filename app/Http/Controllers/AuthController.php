<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function index()
    {
        // Dashboard metrics
        $todayOrdersCount = \App\Models\Order::whereDate('created_at', today())->count();
        $monthRevenue = \App\Models\Order::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->sum('total_amount');
        $servicesCount = \App\Models\Service::count();
        $yearCustomers = \App\Models\Client::whereYear('created_at', now()->year)->count();
        $recentOrders = \App\Models\Order::with('service')->latest()->limit(8)->get();

        // 30-day trends for orders & revenue
        $start = now()->startOfDay()->subDays(29);
        $labels = [];
        $ordersSeries = [];
        $revenueSeries = [];
        for ($i = 0; $i < 30; $i++) {
            $d = (clone $start)->addDays($i);
            $labels[] = $d->format('d M');
            $dayOrders = \App\Models\Order::whereDate('created_at', $d->toDateString())->count();
            $dayRevenue = \App\Models\Order::whereDate('created_at', $d->toDateString())->sum('total_amount');
            $ordersSeries[] = (int) $dayOrders;
            $revenueSeries[] = (int) $dayRevenue;
        }

        // Content/activity widgets
        $postsLast30 = \App\Models\Post::whereDate('created_at', '>=', $start)->count();
        $testimonialsLast30 = \App\Models\Testimonial::whereDate('created_at', '>=', $start)->count();

        // Invoices metrics
        $invoicesThisMonth = \App\Models\Invoice::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();
        $unpaidInvoices = \App\Models\Invoice::with('client')
            ->where(function($q){ $q->where('status', '!=', 'paid')->orWhereNull('status'); })
            ->latest()->limit(10)->get();
        $unpaidTotal = \App\Models\Invoice::where(function($q){ $q->where('status', '!=', 'paid')->orWhereNull('status'); })
            ->sum('total_amount');

        // Pending orders table
        $pendingOrders = \App\Models\Order::with('service')
            ->whereIn('status', ['pending','in_progress','baru'])
            ->latest()->limit(10)->get();

        return view('dashboard', compact(
            'todayOrdersCount', 'monthRevenue', 'servicesCount', 'yearCustomers', 'recentOrders',
            'labels', 'ordersSeries', 'revenueSeries',
            'postsLast30', 'testimonialsLast30', 'invoicesThisMonth', 'unpaidInvoices', 'unpaidTotal',
            'pendingOrders'
        ));
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // reCAPTCHA visible checkbox (v2) verification if configured
        $siteKey = (string) config('services.recaptcha.site_key');
        $secretKey = (string) config('services.recaptcha.secret_key');
        if (!empty($siteKey) && !empty($secretKey)) {
            $token = (string) $request->string('g-recaptcha-response', '');
            if (empty($token)) {
                return back()->withErrors(['recaptcha' => 'Verifikasi keamanan diperlukan.'])->withInput($request->only('login'));
            }
            try {
                $resp = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret' => $secretKey,
                    'response' => $token,
                    'remoteip' => $request->ip(),
                ])->json();
                $allowedHost = $request->getHost();
                $hostVal = $resp['hostname'] ?? null;
                $success = (bool) ($resp['success'] ?? false);
                $ok = $success && (empty($hostVal) || $hostVal === $allowedHost || \Illuminate\Support\Str::contains($allowedHost, (string) $hostVal));
                if (!$ok) {
                    Log::warning('reCAPTCHA login failed', ['resp' => $resp]);
                    return back()->withErrors(['recaptcha' => 'Gagal verifikasi reCAPTCHA. Silakan coba lagi.'])->withInput($request->only('login'));
                }
            } catch (\Throwable $e) {
                Log::error('reCAPTCHA login error: ' . $e->getMessage());
            }
        }

        $credentialsInput = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
            'remember' => ['nullable', 'boolean'],
        ]);

        $login = $credentialsInput['login'];
        $password = $credentialsInput['password'];
        $remember = $request->boolean('remember');

        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $credentials = [
            $field => $login,
            'password' => $password,
        ];

        if (\Illuminate\Support\Facades\Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'login' => __('These credentials do not match our records.'),
        ])->withInput($request->only('login'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
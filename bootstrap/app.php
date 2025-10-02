<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Routing\Exceptions\InvalidSignatureException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Alias middleware kustom
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);

        // Konfigurasi trusted proxies & hosts via environment
        $proxies = array_filter(array_map('trim', explode(',', (string) env('TRUSTED_PROXIES', ''))));
        if (!empty($proxies)) {
            $middleware->trustProxies(at: $proxies);
        }

        $hosts = array_filter(array_map('trim', explode(',', (string) env('TRUSTED_HOSTS', ''))));
        if (!empty($hosts)) {
            $middleware->trustHosts(at: $hosts);
        }
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Render a friendly page for invalid/expired signed URLs
        $exceptions->render(function (InvalidSignatureException $e, $request) {
            return response()->view('public.signed-invalid', [
                'title' => 'Tautan Tidak Valid',
                'message' => 'Maaf, tautan ini tidak valid atau sudah kedaluwarsa. Silakan minta tautan baru atau hubungi kami.',
            ], 403);
        });
    })->create();

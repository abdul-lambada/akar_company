<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

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
        //
    })->create();

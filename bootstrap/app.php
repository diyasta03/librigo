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
        $middleware->alias([
            // Alias yang Anda tambahkan sebelumnya
            'admin' => \App\Http\Middleware\AdminMiddleware::class, 

            // --- UBAH DUA BARIS INI ---
            'auth' => \Illuminate\Auth\Middleware\Authenticate::class, // Ubah ini
            'guest' => \Illuminate\Auth\Middleware\RedirectIfAuthenticated::class, // Ubah ini

            // Mungkin ada alias lain dari Kernel yang Anda tambahkan, pastikan semua benar
            'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
            'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        ]);

        // ... (bagian lain dari withMiddleware) ...
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
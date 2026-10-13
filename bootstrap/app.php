<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    // Daftarkan berkas rute web dan konsol serta endpoint pemeriksaan kesehatan.
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // mendaftarkan middleware agar bisa digunakan
        $middleware->alias([
            // 'namamiddleware' => lokasi file
            'IsLoggedIn' => App\Http\Middleware\IsLoggedIn::class,
            'IsGuest' => App\Http\Middleware\IsGuest::class,
            'IsAdmin'=> App\Http\Middleware\IsAdmin::class
        ]);
    })
    // Gunakan respons JSON untuk permintaan API atau permintaan yang mengharapkannya.
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn(Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();

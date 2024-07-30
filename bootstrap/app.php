<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Configuration\Providers;
use Illuminate\Foundation\Configuration\Routes;
use App\Http\Middleware\NoCacheHeaders;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Define tus middlewares aquí
        $middleware->alias([
            'no.cache' => NoCacheHeaders::class, // Asigna un alias a tu middleware
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

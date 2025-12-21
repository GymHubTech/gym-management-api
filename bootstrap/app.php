<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Add CORS to API middleware group (runs on all API routes)
        $middleware->api(prepend: [
            \Illuminate\Http\Middleware\HandleCors::class,
        ]);
        // Also add to global stack as fallback
        $middleware->prepend(\Illuminate\Http\Middleware\HandleCors::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->withSchedule(function ($schedule) {
        // Schedule membership expiration notifications - Run daily at 9:00 AM
        $schedule->command('membership:check-expiration')
            ->dailyAt('09:00')
            ->timezone('Asia/Manila');

        // Schedule membership status update - Run daily at midnight
        $schedule->command('membership:update-expired-status')
            ->dailyAt('00:00')
            ->timezone('Asia/Manila');
    })
    ->create();

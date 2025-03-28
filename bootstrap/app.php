<?php

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        ]);

        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })


    ->withSchedule(function (Schedule $schedule) {
        $schedule->command('app:bills-auto')->dailyAt('07:00'); // Jalankan setiap hari pukul 00:00
        $schedule->command('app:billsremender')->dailyAt('07:00'); // Jalankan setiap hari pukul 00:00
        $schedule->command('app:debts-remender')->dailyAt('07:00'); // Jalankan setiap hari pukul 00:00
        $schedule->command('app:bpjs')->monthlyOn(13, '05:00');
    })
    ->create();
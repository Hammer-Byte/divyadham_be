<?php

use App\Http\Middleware\AdminUserCheck;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . "/../routes/web.php",
        api: __DIR__ . "/../routes/api.php",
        commands: __DIR__ . "/../routes/console.php",
        health: "/up",
        then: function () {
            Route::namespace("Manage")
                ->prefix("manage")
                ->name("manage.")
                ->group(base_path("routes/manage.php"));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->trustProxies(at: "*");
        $middleware->alias([
            "AdminUserCheck" => AdminUserCheck::class,
        ]);
        $middleware->group("admin", [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \Illuminate\Session\Middleware\AuthenticateSession::class,
        ]);
        //$middleware->append(AdminUserCheck::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();

<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    // Tenant-specific routes
    Route::get('/', function () {
        try {
            return view('tenant-welcome');
        } catch (\Exception $e) {
            logger()->error('Tenant welcome error: ' . $e->getMessage());
            abort(404);
        }
    })->name('tenant.home');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('tenant.dashboard');

    // Debug routes - only in local environment
    if (app()->environment('local')) {
        Route::get('/debug/routes', function () {
            $routes = collect(Route::getRoutes())->map(function ($route) {
                return [
                    'methods' => $route->methods(),
                    'uri' => $route->uri(),
                    'name' => $route->getName(),
                    'middleware' => $route->middleware(),
                    'domain' => $route->getDomain(),
                ];
            });

            return response()->json([
                'tenant' => tenant()->toArray(),
                'domain' => request()->getHost(),
                'routes' => $routes,
                'config' => [
                    'central_domains' => config('tenancy.central_domains'),
                    'database_connection' => config('database.default'),
                ]
            ], 200, [], JSON_PRETTY_PRINT);
        })->name('tenant.debug.routes');
    }
});

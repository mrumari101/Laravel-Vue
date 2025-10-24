<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TenantController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

// Central domain routes (localhost:8000)
Route::middleware(['web'])->group(function () {
    Route::get('/', function () {
        // Debug information
        $host = request()->getHost();
        $centralDomains = config('tenancy.central_domains');

        return view('welcome')->with([
            'debug' => [
                'current_host' => $host,
                'central_domains' => $centralDomains,
                'is_central' => in_array($host, $centralDomains),
            ]
        ]);
});
});
// Tenant management routes
Route::middleware(['web'])->group(function () {
    Route::get('/tenants/create', [TenantController::class, 'showCreateForm'])->name('tenants.create.form');
    Route::post('/tenants/create', [TenantController::class, 'create'])->name('tenants.create');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

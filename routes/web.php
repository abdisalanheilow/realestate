<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])
        ->name('admin.dashboard');
    Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])
        ->name('admin.logout');
}); // End Group Admin Middleware

Route::middleware(['auth', 'role:agent'])->group(function () {
    Route::get('/agent/dashboard', [AgentController::class, 'AgentDashboard'])
        ->name('agent.dashboard');
}); // End Group Agent Middleware

Route::get('/admin/login', [AdminController::class, 'AdminLogin'])
    ->name('admin.login');

Route::get('/run-migration', function () {
    Artisan::call('migrate:fresh --seed');
    return "Migration executed successfully";
});

Route::get('/clear-cache', function () {
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    return 'Cache & View Cleared! <br> <a href="/admin/login">Go to Login</a>';
});

Route::get('/debug-files', function () {
    $path = resource_path('views');
    $files = File::allFiles($path);
    $directories = File::directories($path);

    echo "<h3>Directories in resources/views:</h3>";
    foreach ($directories as $dir) {
        echo $dir . "<br>";
    }

    echo "<h3>Files in resources/views (recursive):</h3>";
    foreach ($files as $file) {
        echo $file->getRelativePathname() . "<br>";
    }
});


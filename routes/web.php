<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Binafy\LaravelUserMonitoring\Models\ActionMonitoring;

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


Route::get('/test-action', function () {

    ActionMonitoring::create([
        'user_id' => auth()->id(),
        'action_type' => 'test',
        'table_name' => 'demo',
        'browser_name' => request()->header('User-Agent'),
        'platform' => php_uname('s'),
        'device' => 'Desktop',
        'ip' => request()->ip(),
        'user_guard' => 'web',
        'page' => request()->url(),
    ]);

    return "Action stored successfully!";
})->middleware('auth'); // <- Add this

require __DIR__.'/auth.php';
require __DIR__.'/user-monitoring.php';

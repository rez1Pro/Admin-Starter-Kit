<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', fn()  => Inertia::render('Dashboard'))->name('dashboard');
    Route::get('/example', fn()  => Inertia::render('Example'))->name('example');

    Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
        Route::resource('/', UserController::class)->parameter('', 'user')->whereNumber('user');
        Route::resource('roles', RoleController::class)->parameter('', 'role')->whereNumber('role');
    });
    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index')->middleware('check:setting:view');
    Route::patch('/settings', [SettingController::class, 'update'])->name('settings.update')->middleware('check:setting:update');
});

require __DIR__ . '/auth.php';

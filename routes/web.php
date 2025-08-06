<?php

use App\Http\Controllers\ProfileController;
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

require __DIR__.'/auth.php';

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('dashboards/website-analytics', function () {
    return view('dashboards.website-analytics');
})->name('dashboards.web-analytics');

Route::get('/apps/user-management/users/list', function () {
    return view('apps.user-management.users.list');
})->name('users.list');

Route::get('/apps/user-management/users/view', function () {
    return view('apps.user-management.users.view');
})->name('users.view');

Route::get('/apps/user-management/roles/list', function () {
    return view('apps.user-management.roles.list');
})->name('roles.list');

Route::get('/apps/user-management/roles/view', function () {
    return view('apps.user-management.roles.view');
})->name('roles.view');

Route::get('/apps/user-management/perminssions', function () {
    return view('apps.user-management.permissions');
})->name('users.perms');

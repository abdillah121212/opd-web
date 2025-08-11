<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';


#authentication.sign-in sign-up
Route::get('sign-in', function () {
    return view('authentication.layouts.corporate.sign-in');
})->name('sign-in');

Route::get('sign-up', function () {
    return view('authentication.layouts.corporate.sign-up');
})->name('sign-up');


#views.general
Route::get('index', function () {
    return view('index');
})->name('index');


#dashboards
Route::get('dashboards/website-analytics', function () {
    return view('dashboards.website-analytics');
})->name('dashboards.web-analytics');


#apps.user-management
Route::get('/apps/user-management/users/list', function () {
    return view('apps.user-management.users.list');
})->name('users.list');

Route::get('/apps/user-management/users/view', function () {
    return view('apps.user-management.users.view');
})->name('users.view');

Route::get('/apps/user-management/users/list', [UserController::class, 'index'])
    ->name('users.list');

Route::get('/apps/user-management/roles/view', function () {
    return view('apps.user-management.roles.view');
})->name('roles.view');

Route::get('/apps/user-management/perminssions', function () {
    return view('apps.user-management.permissions');
})->name('users.perms');


#account
Route::get('account/overview', function () {
    return view('account.overview');
})->name('acc.overview');

Route::get('account/settings', function () {
    return view('account.settings');
})->name('acc.settings');

<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia\Inertia::render('Dashboard');
})->name('dashboard');

Route::resource('users', 'App\Http\Controllers\UserController', ['only'=>['index']]);
Route::resource('order', 'App\Http\Controllers\OrderController', ['only'=>['index','create']]);

Route::namespace('admin')->prefix('admin')->name('admin.')->group(function () {
    Auth::routes([
        'register' => true,
        'reset' =>  false,
        'verify' => false,
    ]);
    Route::middleware('auth.admin')->group(function () {
        Route::resource('home', 'AdminController', ['only'=>['index']]);
    });
});

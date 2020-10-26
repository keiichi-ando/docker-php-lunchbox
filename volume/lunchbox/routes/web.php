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

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function (Request $request) {
    $team = auth()->user()->currentTeam;
    // \Log::debug(auth()->user()->teamRole($team));
    if ($team->name === '管理者') {
        return Inertia\Inertia::render('Dashboard');
    }
    return redirect('order');
})->name('dashboard');

Route::resource('users', 'App\Http\Controllers\UserController', ['only'=>['index']]);
Route::resource('order', 'App\Http\Controllers\OrderController', ['only'=>['index','create']]);

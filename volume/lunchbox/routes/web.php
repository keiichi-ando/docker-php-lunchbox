<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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
    return view('entrance');
});

Route::get('/welcome', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function (Request $request) {
    $team = $request->user()->currentTeam;
    
    if ($request->user()->hasTeamPermission($team, 'member:regist')){
        return Inertia\Inertia::render('Dashboard');
    }
    return redirect('order');
})->name('dashboard');

Route::resource('users', 'App\Http\Controllers\UserController', ['only'=>['index']]);
Route::resource('order', 'App\Http\Controllers\OrderController', ['only'=>['index','create']]);

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

Route::get('/vue', function () {
    return view('dev-vue');
});

Route::get("/api/sample", function () {
    for ($i=0;$i++;$i<4) {
        // if (date('W'))
    }
    $g = new DateTime();
    foreach(range(0, 27) as $i){
        $g->setISODate(date('Y'), date('W'), $i);
        $date[] = $g->format('Y-m-d');
    }
    $array[0] = array_slice($date, 0, 7); //1週目
    $array[1] = array_slice($date, 7, 7); // 2週目
    $array[2] = array_slice($date, 14, 7);; // 3週目
    $array[3] = array_slice($date, 21); // 4週目

    return ["name" => "Vue", "calendar"=> $array];
});

Route::get('/test', function () {
    return 'Hello laravel world';
});


Route::get('/test/json', function () {
    return ['Hello laravel world', 1,2,3];
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

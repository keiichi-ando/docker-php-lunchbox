<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("/calendar", function () {
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
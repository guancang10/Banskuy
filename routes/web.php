<?php

use Illuminate\Support\Facades\Route;
use Ofi\Route\AutoRoute;
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

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::view('/Forum','Forum/Forum');

// Route::view('/ViewForum','Forum/ViewForum');

// Route::view('/ViewThread','Forum/ViewThread');

// Route::view('/Profile','Profile/profile');

AutoRoute::init();


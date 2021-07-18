<?php

use App\Http\Controllers\ShortLinkController;
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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('short-link',
    [ShortLinkController::class, 'index']
)->name('generate.short.link');

Route::post('short-link',
    [ShortLinkController::class, 'store']
)->name('generate.short.link.post');

Route::get('{code}',
    [ShortLinkController::class, 'shortLink']
)->name('short.link');



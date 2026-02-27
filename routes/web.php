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
    return view('dashboard');
})->name('dashboard');

Route::prefix('pages')->name('pages.')->group(function () {
    Route::get('/account-settings', function () {
        return view('pages.account-settings');
    })->name('account-settings');
    
    Route::get('/profile', function () {
        return view('pages.profile');
    })->name('profile');
});

// Temporary test route for checkpoint verification
Route::get('/test-layout', function () {
    return view('test-layout');
})->name('test-layout');

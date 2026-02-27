<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PageController;

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

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::prefix('pages')->name('pages.')->group(function () {
    Route::get('/account-settings', [PageController::class, 'accountSettings'])
        ->name('account-settings');
    
    Route::get('/profile', [PageController::class, 'profile'])
        ->name('profile');
});

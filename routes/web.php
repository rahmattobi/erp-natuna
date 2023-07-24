<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\TimelineController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::controller(AuthController::class)->group(function (){
    Route::get('login', 'login')->name('login');
    Route::post('login', 'loginAction')->name('login.action');
    Route::get('register', 'register')->name('register');
    Route::post('register', 'registerSave')->name('register.save');
    Route::get('logout', 'logout')->middleware('auth')->name('logout');
});

Route::middleware(['auth'])->group(function () {
    // Routes within this group require authentication

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::controller(TimelineController::class)->prefix('timelines')->group(function (){
        Route::get('', 'index')->name('timeline');
        Route::get('input', 'create')->name('timeline.input');
        Route::get('edit/{id}', 'edit')->name('timeline.edit');
        Route::put('edit/{id}', 'update')->name('timeline.update');
        Route::post('', 'store')->name('timeline.action');
        Route::delete('destroy/{id}', 'destroy')->name('timeline.delete');
    });

    Route::controller(InvoiceController::class)->prefix('invoice')->group(function (){
        Route::get('', 'index')->name('invoice.index');
        Route::get('input', 'create')->name('invoice.input');
        Route::post('', 'store')->name('invoice.action');
        Route::get('invoiceDetail/{id}', 'show')->name('invoice.view');
        // // Route::get('', 'edit/{id}')->name('invoice.edit');
        // // Route::delete('', 'destroy/{id}')->name('invoice.delete');
    });

});




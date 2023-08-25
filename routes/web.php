<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\KaryawanController;
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
        Route::get('project', 'inv_project')->name('invoice.inv_project');
        Route::get('inputDetail/{id}', 'inputDetail')->name('invoice.inputDetail');
        Route::post('', 'store')->name('invoice.action');
        Route::post('project', 'inputProject')->name('invoice.inputProject');
        Route::post('{id}', 'actionDetail')->name('invoice.actionDetail');
        Route::get('edit/{id}', 'edit')->name('invoice.edit');
        Route::get('editDetail/{id}', 'editDetail')->name('invoice.editDetail');
        Route::put('update/{id}', 'update')->name('invoice.update');
        Route::put('bayar/{id}', 'bayarInvoice')->name('invoice.bayar');
        Route::put('edit/{id}', 'updateDetail')->name('invoice.updateDetail');
        Route::delete('deleteInvoiceDetail/{id}', 'deleteInvoiceDetail')->name('invoice.deleteDetail');
        Route::get('{id}', 'show')->name('invoice.view');
        Route::get('{id}/print'  , 'printInvoice')->name('invoice.printInvoice');
        Route::get('{id}/view'  , 'terbitkanInvoice')->name('invoice.terbitkanInvoice');
        Route::delete('destroy/{id}', 'destroy')->name('invoice.delete');
        Route::put('revisi/{id}', 'revision')->name('invoice.revisi');
        Route::post('pajak/{id}', 'inputPajak')->name('invoice.pajak');
    });

    Route::controller(InvoiceController::class)->prefix('finance')->group(function (){
        Route::get('', 'finance')->name('finance.index');
        Route::get('{id}', 'showFinance')->name('finance.showFinance');
        Route::put('accInvoice/{id}', 'accInvoice')->name('finance.acc');
        Route::post('/{id}', 'inputRevisi')->name('finance.revisi');
    });


    Route::controller(KaryawanController::class)->prefix('user')->group(function (){
        Route::get('', 'index')->name('user.index');
        Route::post('', 'store')->name('user.action');
        Route::get('edit/{id}', 'edit')->name('user.edit');
        Route::put('edit/{id}', 'update')->name('user.update');
        Route::delete('destroy/{id}', 'destroy')->name('user.delete');
    });

});




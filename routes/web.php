<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\InvoiceController;


//Front End
Route::get('/', function () {
    return view('welcome');
});



//Backend




Route::prefix('dashboard')->middleware(['auth'])->group(function () {

    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');


    Route::resource('client', ClientController::class);
    Route::get('task/client/{client:username}', [ClientController::class, 'searchTaskByClient'])->name('searchTaskByClient');
    Route::resource('task', TaskController::class);
    Route::put('task/{task}/complete', [TaskController::class, 'markAsCcomplete'])->name('markAsCcomplete');
    Route::get('invoices', [InvoiceController::class, 'index'])->name('invoice.index');

    Route::get('invoice/create', [InvoiceController::class, 'create'])->name('invoice.create');
    Route::get('invoice/{invoice}/edit', [InvoiceController::class, 'edit'])->name('invoice.edit');
    Route::post('invoice/store', [InvoiceController::class, 'store'])->name('invoice.store');
    Route::put('invoice/{invoicce}/update', [InvoiceController::class, 'update'])->name('invoice.update');
    Route::delete('invoice/{invoicce}/delete', [InvoiceController::class, 'destroy'])->name('invoice.destroy');
    Route::delete('invoice/{invoicce}', [InvoiceController::class, 'show'])->name('invoice.show');

});


require __DIR__.'/auth.php';

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SettingsController;
use App\Mail\InvoiceEmail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

//Backend


Route::prefix('/')->middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        $user = User::find(Auth::user()->id);

        return view('dashboard')->with([
            'user'              => $user,
            'pending_tasks'     => $user->tasks->where('status','pending'),
            'unpaid_invoices'   => $user->invoices->where('status','unpaid'),
            'paid_invoices'   => $user->invoices->where('status','paid'),
        ]);
    })->name('dashboard');

    // Client Route
    Route::resource('client', ClientController::class);

    // Task Route
    Route::resource('task', TaskController::class);
    Route::put('task/{task}/complete', [TaskController::class, 'markAsComplete'])->name('markAsComplete');



     // Invoices Route
     Route::prefix('invoices')->group(function () {
        Route::get('/', [InvoiceController::class, 'index'])->name('invoice.index');
        Route::get('create', [InvoiceController::class, 'create'])->name('invoice.create');
        Route::put('{invoice}/update', [InvoiceController::class, 'update'])->name('invoice.update');
        Route::delete('{invoice}/delete', [InvoiceController::class, 'destroy'])->name('invoice.destroy');
        Route::get('invoice', [InvoiceController::class, 'invoice'])->name('invoice');
        Route::get('email/send/{invoice:invoice_id}', [InvoiceController::class, 'sendEmail'])->name('invoice.sendEmail');
    });

    // Settings
    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('settings/update', [SettingsController::class, 'update'])->name('settings.update');



    // Route::get('email', function () {

    //     return new InvoiceEmail();
    // });

});



require __DIR__.'/auth.php';

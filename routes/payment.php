<?php

use App\Http\Controllers\Payment\WebPaymentController;
 
Route::middleware(['web.auth'])->group(function () {
    Route::post('/payment/initiate',            [WebPaymentController::class, 'initiate'])->name('payment.initiate');
    Route::get('/payment/callback',             [WebPaymentController::class, 'callback'])->name('payment.callback');
    Route::get('/payment/status/{reference}',   [WebPaymentController::class, 'status'])->name('payment.status');
    Route::get('/payment/cancelled',            [WebPaymentController::class, 'cancelled'])->name('payment.cancelled');
});

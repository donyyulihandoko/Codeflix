<?php

use App\Http\Controllers\PaymentCallbackController;
use Illuminate\Support\Facades\Route;

Route::post('/payments/callback', PaymentCallbackController::class)->name('payments.callback');

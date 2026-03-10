<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\WelcomeController;


Route::post('/view/welcome', [WelcomeController::class, 'welcome']);
Route::post('/view/{view}', [WelcomeController::class, 'show']);


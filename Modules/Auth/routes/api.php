<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\AuthLoginController;

Route::prefix('auth')
    ->name('auth.')
    ->group(static function (): void {
        Route::post('login', AuthLoginController::class)->name('login');
    });

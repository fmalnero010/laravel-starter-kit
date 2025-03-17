<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\AuthLoginController;
use Modules\Auth\Http\Controllers\AuthLogoutController;

Route::prefix('auth')
    ->name('auth.')
    ->group(static function (): void {
        Route::post('login', AuthLoginController::class)->name('login');
        Route::post('logout', AuthLogoutController::class)->name('logout')
            ->middleware(['auth.sanctum']);
    });

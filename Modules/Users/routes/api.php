<?php

use Illuminate\Support\Facades\Route;
use Modules\Users\Http\Controllers\UsersIndexController;

Route::prefix('users')
    ->name('users.')
    ->middleware('auth:api')
    ->group(static function (): void {
        Route::get('/', UsersIndexController::class)->name('index');
    });

<?php

use Illuminate\Support\Facades\Route;
use Modules\Users\Http\Controllers\UsersIndexController;

Route::prefix('users')
    ->name('users.')
    ->group(static function (): void {
        Route::get('/', UsersIndexController::class)->name('index');
    });

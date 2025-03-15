<?php

use App\Enums\Permissions;
use Illuminate\Support\Facades\Route;
use Modules\Users\Http\Controllers\UsersIndexController;
use Spatie\Permission\Middleware\PermissionMiddleware;

Route::prefix('users')
    ->name('users.')
    ->group(static function (): void {
        Route::get('/', UsersIndexController::class)->name('index')
            ->middleware(PermissionMiddleware::using(Permissions::UsersList));
    });

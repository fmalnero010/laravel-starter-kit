<?php

use Illuminate\Support\Facades\Route;
use Modules\Users\Http\Controllers\UsersIndexController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('users', UsersIndexController::class)->names('users');
});

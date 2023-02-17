<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use PreemStudio\Passwordless\Http\Controllers\StorePasswordlessController;

Route::view('/login/passwordless', 'passwordless-views::auth.passphrase')
    ->middleware('web')
    ->name('login.passwordless');

Route::post('/login/passwordless', StorePasswordlessController::class)
    ->middleware('web')
    ->name('login.passwordless.confirmation');

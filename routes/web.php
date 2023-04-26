<?php

declare(strict_types=1);

use BombenProdukt\Passwordless\Http\Controllers\StorePasswordlessController;
use Illuminate\Support\Facades\Route;

Route::view('/login/passwordless', 'passwordless-views::auth.passphrase')
    ->middleware('web')
    ->name('login.passwordless');

Route::post('/login/passwordless', StorePasswordlessController::class)
    ->middleware('web')
    ->name('login.passwordless.confirmation');

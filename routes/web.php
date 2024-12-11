<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use BaseCodeOy\Passwordless\Http\Controllers\StorePasswordlessController;
use Illuminate\Support\Facades\Route;

Route::view('/login/passwordless', 'passwordless-views::auth.passphrase')
    ->middleware('web')
    ->name('login.passwordless');

Route::post('/login/passwordless', StorePasswordlessController::class)
    ->middleware('web')
    ->name('login.passwordless.confirmation');

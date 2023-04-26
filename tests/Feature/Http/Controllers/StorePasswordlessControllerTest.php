<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use BombenProdukt\Passwordless\Enums\AuthSession;
use BombenProdukt\Passwordless\Http\Controllers\StorePasswordlessController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

it('should log out the user and clear the session if the passphrase has expired', function (): void {
    Route::middleware('web')->post('/_test', StorePasswordlessController::class);
    Route::middleware('web')->post('/login', fn () => 'Hello Login')->name('login');

    Carbon::setTestNow('2020-01-01 12:00:00');

    $this
        ->withSession([
            AuthSession::PASSPHRASE => 'passphrase',
            AuthSession::PASSPHRASE_EXPIRATION => Carbon::parse('2020-01-01 11:00:00')->timestamp,
        ])
        ->post('/_test')
        ->assertRedirect(route('login'))
        ->assertSessionHasErrors('passphrase')
        ->assertSessionMissing(AuthSession::PASSPHRASE)
        ->assertSessionMissing(AuthSession::PASSPHRASE_EXPIRATION);
});

it('should throw an exception if the passphrase is invalid', function (): void {
    Route::middleware('web')->post('/_test', StorePasswordlessController::class);

    Carbon::setTestNow('2020-01-01 12:00:00');

    $this
        ->withSession([
            AuthSession::PASSPHRASE => 'passphrase',
            AuthSession::PASSPHRASE_EXPIRATION => Carbon::parse('2020-01-01 12:05:00')->timestamp,
        ])
        ->post('/_test')
        ->assertStatus(302)
        ->assertSessionHasErrors('passphrase');
});

it('should clear the session and execute the fortify login response', function (): void {
    Route::middleware('web')->post('/_test', StorePasswordlessController::class);
    Route::middleware('web')->post('/login', fn () => 'Hello Login')->name('login');

    Carbon::setTestNow('2020-01-01 12:00:00');

    $this
        ->withSession([
            AuthSession::PASSPHRASE => 'passphrase',
            AuthSession::PASSPHRASE_EXPIRATION => Carbon::parse('2020-01-01 12:05:00')->timestamp,
        ])
        ->post('/_test', ['passphrase' => 'passphrase'])
        ->assertRedirect('/home');
});

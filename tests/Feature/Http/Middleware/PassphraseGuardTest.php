<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Middleware;

use BombenProdukt\Passwordless\Enums\AuthSession;
use BombenProdukt\Passwordless\Http\Middleware\PassphraseGuard;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

it('should fulfill the request if no passphrase is present', function (): void {
    Route::middleware(['web', PassphraseGuard::class])->get('/_test', fn () => ['key' => 'value']);

    $this
        ->get('/_test')
        ->assertJson(['key' => 'value']);
});

it('should log out the user if the passphrase has expired', function (): void {
    Route::middleware('web')->get('//', fn () => ['key' => 'home'])->name('home');
    Route::middleware(['web', PassphraseGuard::class])->get('/_test', fn () => ['key' => 'value']);

    Carbon::setTestNow('2020-01-01 12:00:00');

    $this
        ->withSession([
            AuthSession::PASSPHRASE => 'passphrase',
            AuthSession::PASSPHRASE_EXPIRATION => Carbon::parse('2020-01-01 11:00:00')->timestamp,
        ])
        ->get('/_test')
        ->assertRedirect(route('home'))
        ->assertSessionMissing(AuthSession::PASSPHRASE)
        ->assertSessionMissing(AuthSession::PASSPHRASE_EXPIRATION);
});

it('should complete te request if its name starts with [login]', function (): void {
    Route::middleware('web')->get('//', fn () => ['key' => 'home'])->name('home');
    Route::middleware(['web', PassphraseGuard::class])->get('/_test', fn () => ['key' => 'value'])->name('login.thing');

    Carbon::setTestNow('2020-01-01 12:00:00');

    $this
        ->withSession([
            AuthSession::PASSPHRASE => 'passphrase',
            AuthSession::PASSPHRASE_EXPIRATION => Carbon::parse('2020-01-01 12:05:00')->timestamp,
        ])
        ->get('/_test')
        ->assertOk();
});

it('should redirect to the passwordless form if the token has not expired but also not consumed', function (): void {
    Route::middleware('web')->get('//', fn () => ['key' => 'home'])->name('home');
    Route::middleware(['web', PassphraseGuard::class])->get('/_test', fn () => ['key' => 'value']);

    Carbon::setTestNow('2020-01-01 12:00:00');

    $this
        ->withSession([
            AuthSession::PASSPHRASE => 'passphrase',
            AuthSession::PASSPHRASE_EXPIRATION => Carbon::parse('2020-01-01 12:05:00')->timestamp,
        ])
        ->get('/_test')
        ->assertRedirect(route('login.passwordless'));
});

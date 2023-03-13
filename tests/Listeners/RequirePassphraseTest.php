<?php

declare(strict_types=1);

namespace Tests\Listeners;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use PreemStudio\Passwordless\Listeners\RequirePassphrase;
use PreemStudio\Passwordless\Notifications\SendPassphrase;
use Tests\User;

beforeEach(fn () => $this->subject = new RequirePassphrase);

it('should send a notification', function (): void {
    Notification::fake();

    $this->subject->handle((object) [
        'user' => $user = new User,
    ]);

    Notification::assertSentTo($user, SendPassphrase::class);
});

it('should not send a notification if the user is already authenticated', function (): void {
    Notification::fake();

    Auth::shouldReceive('viaRemember')->once()->andReturn(true);

    $this->subject->handle((object) [
        'user' => new User,
    ]);

    Notification::assertNothingSent();
});

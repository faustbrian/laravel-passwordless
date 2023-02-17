<?php

declare(strict_types=1);

namespace Tests\Unit\Notifications;

use PreemStudio\Passwordless\Notifications\SendPassphrase;

beforeEach(fn () => $this->subject = new SendPassphrase('super-unique-random-passphrase-thing'));

it('should render the notification contents', function (): void {
    expect((string) $this->subject->toMail()->render())->toContain('super-unique-random-passphrase-thing');
});

it('should only send it to email', function (): void {
    expect($this->subject->via())->toBe(['mail']);
});

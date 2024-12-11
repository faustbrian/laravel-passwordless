<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Tests\Unit\Notifications;

use BaseCodeOy\Passwordless\Notifications\SendPassphrase;

beforeEach(fn (): \BaseCodeOy\Passwordless\Notifications\SendPassphrase => $this->subject = new SendPassphrase('super-unique-random-passphrase-thing'));

it('should render the notification contents', function (): void {
    expect((string) $this->subject->toMail()->render())->toContain('super-unique-random-passphrase-thing');
});

it('should only send it to email', function (): void {
    expect($this->subject->via())->toBe(['mail']);
});

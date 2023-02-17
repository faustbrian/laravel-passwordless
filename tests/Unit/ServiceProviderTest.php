<?php

declare(strict_types=1);

namespace Tests\Unit;

use PreemStudio\Passwordless\Http\Middleware\PassphraseGuard;

it('should register the guard middleware', function (): void {
    expect($this->app->router->getMiddlewareGroups()['web'])->toContain(PassphraseGuard::class);
});

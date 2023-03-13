<?php

declare(strict_types=1);

namespace PreemStudio\Passwordless;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Event;
use PreemStudio\Jetpack\Package\AbstractServiceProvider;
use PreemStudio\Passwordless\Http\Middleware\PassphraseGuard;
use PreemStudio\Passwordless\Listeners\RequirePassphrase;

final class ServiceProvider extends AbstractServiceProvider
{
    public function bootingPackage(): void
    {
        $this->bootEventListeners();

        $this->bootMiddleware();
    }

    private function bootEventListeners(): void
    {
        Event::listen(\Illuminate\Auth\Events\Login::class, RequirePassphrase::class);
        Event::listen(\Illuminate\Auth\Events\Registered::class, RequirePassphrase::class);
    }

    private function bootMiddleware(): void
    {
        /** @var Router $router */
        $router = $this->app['router'];
        $router->pushMiddlewareToGroup('web', PassphraseGuard::class);
    }
}

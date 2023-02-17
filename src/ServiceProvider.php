<?php

declare(strict_types=1);

namespace PreemStudio\Passwordless;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Event;
use PreemStudio\Passwordless\Http\Middleware\PassphraseGuard;
use PreemStudio\Passwordless\Listeners\RequirePassphrase;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

final class ServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-passwordless')
            ->hasViews()
            ->hasRoute('web')
            ->hasMigration('create_package_tables');
    }

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

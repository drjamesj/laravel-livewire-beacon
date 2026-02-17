<?php

namespace Executable\LivewireBeacon;

use Executable\LivewireBeacon\Listeners\ReverbMessageReceivedListener;
use Illuminate\Config\Repository;
use Illuminate\Events\Dispatcher;
use Illuminate\Routing\Router;
use Illuminate\View\Compilers\BladeCompiler;
use Laravel\Reverb\Events\MessageReceived;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LivewireBeaconServiceProvider extends PackageServiceProvider
{
    public BladeCompiler $blade;
    public Repository $config;
    public Dispatcher $event;
    public Router $route;

    public function boot(BladeCompiler $blade, Repository $config, Dispatcher $event, Router $route): void
    {
        $this->blade = $blade;
        $this->config = $config;
        $this->event = $event;
        $this->route = $route;
    }
    
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-livewire-beacon')
            ->hasConfigFile();
    }

    public function packageBooted()
    {
        $this->blade->directive('livewireBeaconScripts', [LivewireBeacon::class, 'livewireBeaconScripts']);

        if (! $this->config->get('livewire-beacon.enabled', true)) {
            return;
        }

        $this->event->listen(
            MessageReceived::class,
            ReverbMessageReceivedListener::class,
        );

        $route = $this->route->get(
            $this->config->get('app.debug') ? '/livewire/beacon.js' : 'livewire/beacon.min.js',
            [LivewireBeacon::class, 'returnJavascriptAsFile']
        );

        $url = str($route->uri())->when(! str($url)->isUrl(), fn ($url) => $url->start('/'))->toString();

        LivewireBeacon::$javascriptRoute = $url;
    }
}

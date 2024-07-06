<?php

namespace Executable\LivewireBeacon;

use Executable\LivewireBeacon\Listeners\ReverbMessageReceivedListener;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Laravel\Reverb\Events\MessageReceived;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LivewireBeaconServiceProvider extends PackageServiceProvider
{
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
        Event::listen(
            MessageReceived::class,
            ReverbMessageReceivedListener::class,
        );

        Blade::directive('livewireBeaconScripts', [LivewireBeacon::class, 'livewireBeaconScripts']);

        $route = Route::get(
            config('app.debug') ? '/livewire/beacon.js' : 'livewire/beacon.min.js',
            [LivewireBeacon::class, 'returnJavascriptAsFile']
        );

        $url = $route->uri();
        $url = (string) str($url)->when(! str($url)->isUrl(), fn ($url) => $url->start('/'));

        LivewireBeacon::$javascriptRoute = $url;
    }
}

<?php

namespace Executable\LivewireBeacon;

use Livewire\Drawer\Utils;

class LivewireBeacon
{
    public static $javascriptRoute = '';

    public static function livewireBeaconScripts($expression)
    {
        if (! config('livewire-beacon.enabled', true)) {
            return;
        }

        return '{!! \Executable\LivewireBeacon\LivewireBeacon::scripts('.$expression.') !!}';
    }

    public static function scripts($options = [])
    {
        $url = self::$javascriptRoute;
        $channel = config('livewire-beacon.channel');
        $inboundEvent = config('livewire-beacon.events.inbound');
        $outboundEvent = config('livewire-beacon.events.outbound');

        return <<<HTML
            <script src="{$url}" type="module" data-channel="{$channel}" data-inbound="{$inboundEvent}" data-outbound="{$outboundEvent}" id="livewire-beacon"></script>
        HTML;
    }

    public function returnJavascriptAsFile()
    {
        return Utils::pretendResponseIsFile(
            config('app.debug')
                ? __DIR__.'/../dist/beacon.js'
                : __DIR__.'/../dist/beacon.min.js'
        );
    }
}

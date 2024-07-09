<?php

namespace Executable\LivewireBeacon\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Executable\LivewireBeacon\LivewireBeacon
 */
class LivewireBeacon extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Executable\LivewireBeacon\LivewireBeacon::class;
    }
}

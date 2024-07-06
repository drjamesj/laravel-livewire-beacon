<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Beacon Channel
    |--------------------------------------------------------------------------
    |
    | This option controls which channel name is used for broadcasting
    | and receiving Beacon events using the Pusher protocol.
    |
    */

    'channel' => env('LIVEWIRE_BEACON_CHANNEL', 'beacon-channel'),

    /*
    |--------------------------------------------------------------------------
    | Beacon Events
    |--------------------------------------------------------------------------
    |
    | These mappings provide the name of the events used for incoming
    | and outgoing Beacon events. You may change these if you wish.
    |
    */

    'events' => [
        'inbound' => 'BeaconInboundEvent',
        'outbound' => 'BeaconOutboundEvent',
    ],
];

<?php

namespace Executable\LivewireBeacon\Listeners;

use Laravel\Reverb\Events\MessageReceived;
use Livewire\Mechanisms\HandleRequests\HandleRequests;

class ReverbMessageReceivedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(MessageReceived $event): void
    {
        $message = json_decode($event->message, associative: true);
        if (!isset($message['event']) || $message['event'] !== config('livewire-beacon.events.inbound')) {
            return;
        }

        app('request')->merge([
            'components' => [
                $message['data']['payload'] ?? [],
            ],
        ]);

        $livewireHandleRequests = app()->make(HandleRequests::class);
        $result = $livewireHandleRequests->handleUpdate();

        $event->connection->send(json_encode([
            'event' => 'BeaconOutboundEvent',
            'data' => json_encode([
                'id' => $message['data']['id'],
                'result' => $result,
            ]),
            'channel' => config('livewire-beacon.channel'),
        ]));
    }
}

<?php

namespace Executable\LivewireBeacon\Listeners;

use Illuminate\Config\Repository;
use Illuminate\Http\Request;
use Laravel\Reverb\Events\MessageReceived;
use Livewire\Mechanisms\HandleRequests\HandleRequests;

class ReverbMessageReceivedListener
{
    public function __construct(
        public Request $request,
        public HandleRequests $handlesRequests,
        public Repository $config,
    )
    {
        //
    }

    public function handle(MessageReceived $event): void
    {
        $message = json_decode($event->message, associative: true);
        if (! isset($message['event']) || $message['event'] !== $this->config->get('livewire-beacon.events.inbound')) {
            return;
        }

        $this->request->merge([
            'components' => [
                $message['data']['payload'] ?? [],
            ],
        ]);

        $result = $this->handleRequests->handleUpdate();

        $event->connection->send(json_encode([
            'event' => 'BeaconOutboundEvent',
            'data' => json_encode([
                'id' => $message['data']['id'],
                'result' => $result,
            ]),
            'channel' => $this->config->get('livewire-beacon.channel'),
        ]));
    }
}

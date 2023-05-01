<?php

namespace App\CommandBus\Core;

use App\CommandBus\Core\Contract\CommandBusInterface;
use League\Tactician\CommandBus as TacticianCommandBus;


class CommandBus implements CommandBusInterface
{

    private TacticianCommandBus $bus;

    public function __construct(TacticianCommandBus $bus)
    {
        $this->bus = $bus;
    }

    public function dispatch(Command $command, array $payload = []): void
    {
        if (filled($payload)) {
            $command->handlePayload($payload);
        }

        $this->bus->handle($command);
    }
}

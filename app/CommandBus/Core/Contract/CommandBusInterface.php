<?php


namespace App\CommandBus\Core\Contract;


use App\CommandBus\Core\Command;

interface CommandBusInterface
{
    public function dispatch(Command $command, array $payload = []);
}

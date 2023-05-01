<?php

declare(strict_types=1);

namespace App\CommandBus\API\Auth\Handlers;


use App\CommandBus\API\Auth\Commands\LogoutCommand;

class LogoutHandler
{

    public function handle(LogoutCommand $command)
    {
        \auth()->user()->tokens()->delete();
    }
}

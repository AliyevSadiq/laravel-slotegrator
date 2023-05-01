<?php

declare(strict_types=1);

namespace App\CommandBus\API\Auth\Handlers;


use App\CommandBus\API\Auth\Commands\RegistrationCommand;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegistrationHandler
{

    public function handle(RegistrationCommand $command)
    {
        $user = new User();

        $user->name = $command->name;
        $user->email = $command->email;
        $user->password = Hash::make($command->password);
        $user->save();
    }
}

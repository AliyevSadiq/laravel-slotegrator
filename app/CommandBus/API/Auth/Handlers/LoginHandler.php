<?php

declare(strict_types=1);

namespace App\CommandBus\API\Auth\Handlers;


use App\CommandBus\API\Auth\Commands\LoginCommand;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class LoginHandler
{

    public function handle(LoginCommand $command)
    {
        $user = User::where('email', $command->email)->first();

        if (!$user || !Hash::check($command->password, $user->password)) {
            throw new \Exception(
                'Incorrect username or password',
                Response::HTTP_UNAUTHORIZED
            );
        }
       $command->token=$user->createToken('apiToken')->plainTextToken;
    }
}

<?php

declare(strict_types=1);

namespace App\CommandBus\API\Auth\Commands;

use App\CommandBus\Core\Command;

class LoginCommand extends Command
{
    public string $email;
    public string $password;
    public ?string $token = null;
}

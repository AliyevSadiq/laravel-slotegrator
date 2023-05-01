<?php

namespace App\CommandBus\Core;

use League\Tactician\Exception\MissingHandlerException;
use League\Tactician\Handler\Locator\HandlerLocator;

/**
 * Change namespace parts of command to find handler
 *
 * Examples:
 *  - \Modules\User\Commands\User\CreateUserCommand => \Modules\User\Handlers\User\CreateUserHandler
 */
class ClassNameLocator implements HandlerLocator
{

    public function getHandlerForCommand($commandName): object
    {
        $parts = explode("\\", $commandName);

        $newParts = [];

        foreach ($parts as $key => $part) {
            if ($part == 'Commands') {
                $newParts[] = 'Handlers';
            } elseif ($key === array_key_last($parts)) {
                $newParts[] = str_replace('Command', 'Handler', $part);
            } else {
                $newParts[] = $part;
            }
        }

        $handlerClassName = implode("\\", $newParts);

        if (!class_exists($handlerClassName)) {
            throw MissingHandlerException::forCommand($commandName);
        }

        return app($handlerClassName);
    }

}

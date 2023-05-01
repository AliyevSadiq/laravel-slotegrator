<?php

declare(strict_types=1);

namespace App\CommandBus\API\Favorite\Handlers;

use App\CommandBus\API\Favorite\Commands\DeleteFavoriteCommand;
use Illuminate\Http\Response;

class DeleteFavoriteHandler
{
    public function handle(DeleteFavoriteCommand $command)
    {
        if (auth()->id() !== $command->favorite->user_id) {
            throw new \Exception('Access dneied', Response::HTTP_FORBIDDEN);
        }

        $command->favorite->delete();
    }
}

<?php

declare(strict_types=1);

namespace App\CommandBus\API\Favorite\Handlers;

use App\CommandBus\API\Favorite\Commands\StoreFavoriteCommand;

class StoreFavoriteHandler
{

    public function handle(StoreFavoriteCommand $command)
    {
        auth()->user()->favorites()->firstOrCreate([
            'product_id'=>$command->product->id
        ],[
            'product_id'=>$command->product->id
        ]);
    }
}

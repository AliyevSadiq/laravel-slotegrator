<?php

declare(strict_types=1);

namespace App\CommandBus\API\Favorite\Commands;

use App\CommandBus\Core\Command;
use App\Models\Favorite;

class DeleteFavoriteCommand extends Command
{
    public Favorite $favorite;
}

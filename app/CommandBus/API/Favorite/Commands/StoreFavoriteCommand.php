<?php

declare(strict_types=1);

namespace App\CommandBus\API\Favorite\Commands;

use App\CommandBus\Core\Command;
use App\Models\Product;

class StoreFavoriteCommand extends Command
{
    public Product $product;
}

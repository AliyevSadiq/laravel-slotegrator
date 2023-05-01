<?php

declare(strict_types=1);

namespace App\CommandBus\API\Product\Commands;

use App\CommandBus\Core\Command;
use App\Models\Product;

class DeleteProductCommand extends Command
{
    public Product $product;
}

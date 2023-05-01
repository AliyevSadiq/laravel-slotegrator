<?php

declare(strict_types=1);

namespace App\CommandBus\API\Product\Commands;

use App\CommandBus\Core\Command;
use App\Models\Product;
use Illuminate\Http\UploadedFile;

class SaveProductCommand extends Command
{
    public string $name;
    public string $description;
    public int $category_id;
    public ?array $images=[];
    public ?Product $product=null;
}

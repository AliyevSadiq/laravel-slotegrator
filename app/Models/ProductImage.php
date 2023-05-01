<?php

declare(strict_types=1);

namespace App\Models;

use App\Utils\Manager\StorageManager;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ProductImage extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getDiskName(): string
    {
        return $this->disk_name;
    }

    protected function image(): Attribute
    {
        $manager = (new StorageManager());

        return new Attribute(
            get: fn($value) => $manager->setType($this->type??config('filesystems.storage_repo'))
                ->manage()->setDiskName($this->getDiskName())->getUrl($value),
        );
    }
}

<?php

declare(strict_types=1);

namespace App\Utils\Manager;


use App\Enums\ImageType;
use App\Repository\Storage\AWSStorageRepository;
use App\Repository\Storage\FileStorageRepository;
use App\Repository\Storage\StorageRepositoryInterface;

class StorageManager implements StorageManagerInterface
{

    private string $type;


    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function manage(): StorageRepositoryInterface
    {

        return match ($this->type) {
            ImageType::FILE => new FileStorageRepository(),
            ImageType::AWS => new AWSStorageRepository(),
            default => throw new \Exception('Storage repository not found'),
        };
    }
}

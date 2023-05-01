<?php

declare(strict_types=1);

namespace App\Utils\Manager;


use App\Repository\Storage\StorageRepositoryInterface;

interface StorageManagerInterface
{
    public function setType(string $type):self;

    public function manage(): StorageRepositoryInterface;
}

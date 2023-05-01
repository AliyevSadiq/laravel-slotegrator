<?php

declare(strict_types=1);

namespace App\CommandBus\API\Product\Handlers;

use App\CommandBus\API\Product\Commands\DeleteProductCommand;
use App\Utils\Manager\StorageManagerInterface;

class DeleteProductHandler
{

    public function __construct(private StorageManagerInterface $storageManager)
    {
    }

    public function handle(DeleteProductCommand $command)
    {
        foreach ($command->product->images as $image){
            $manager=$this->storageManager
                ->setType($image->type)
                ->manage()->setDiskName($image->disk_name);

            $originalImage=$image->getAttributes()['image'];

            if(!$manager->fileExists($originalImage)){
                throw new \Exception('The image not exists');
            }

            $manager->deleteFile($originalImage);
        }

        $command->product->delete();
    }
}

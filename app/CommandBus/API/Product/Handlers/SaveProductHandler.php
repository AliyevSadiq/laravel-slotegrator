<?php

declare(strict_types=1);

namespace App\CommandBus\API\Product\Handlers;

use App\CommandBus\API\Product\Commands\SaveProductCommand;
use App\Enums\DiskName;
use App\Enums\ImageType;
use App\Models\Product;
use App\Utils\Manager\StorageManagerInterface;

class SaveProductHandler
{

    public function __construct(private StorageManagerInterface $storageManager)
    {
    }

    public function handle(SaveProductCommand $command)
    {

        $model = $command->product ?? new Product();

        $model->user_id = auth()->id();
        $model->name = $command->name;
        $model->description = $command->description;
        $model->category_id = $command->category_id;
        $model->save();

        if (count(array_filter($command->images))>0) {
            $manager=$this->storageManager
                ->setType(config('filesystems.storage_repo'))
                ->manage()
                ->setDiskName(DiskName::S3);

            foreach ($command->images as $image){
                $model->images()->create([
                    'image'=>$manager->saveFile($image),
                    'disk_name'=>DiskName::S3,
                    'type'=>ImageType::AWS
                ]);
            }
        }
        $command->product=$model;
    }
}

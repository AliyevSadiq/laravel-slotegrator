<?php

namespace Tests\Feature\Utils\Manager;

use App\Enums\ImageType;
use App\Repository\Storage\AWSStorageRepository;
use App\Repository\Storage\FileStorageRepository;
use App\Utils\Filters\ProductFilter\Category;
use App\Utils\Manager\StorageManager;
use Tests\TestCase;

class StorageManagerTest extends TestCase
{
    /** @test */
    public function it_returns_file_storage_repository_when_type_is_file()
    {
        $manager = new StorageManager();
        $manager->setType(ImageType::FILE);

        $this->assertInstanceOf(FileStorageRepository::class, $manager->manage());
    }

    /** @test */
    public function it_returns_aws_storage_repository_when_type_is_aws()
    {
        $manager = new StorageManager();
        $manager->setType(ImageType::AWS);

        $this->assertInstanceOf(AWSStorageRepository::class, $manager->manage());
    }

    /** @test */
    public function it_throws_exception_when_storage_repository_not_found()
    {
        $manager = new StorageManager();
        $manager->setType('invalid_type');

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Storage repository not found');

        $manager->manage();
    }
}

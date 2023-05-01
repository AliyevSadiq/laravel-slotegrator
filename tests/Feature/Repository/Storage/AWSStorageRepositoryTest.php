<?php

namespace Tests\Feature\Repository\Storage;

use App\Repository\Storage\AWSStorageRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AWSStorageRepositoryTest extends TestCase
{
    private AWSStorageRepository $repository;
    private string $testDiskName = 'test-disk';
    private string $fileName = 'test.jpg';

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = new AWSStorageRepository();
        $this->repository->setDiskName($this->testDiskName);
        Storage::fake($this->testDiskName);
    }

    public function testGetUrl(): void
    {


        Storage::disk($this->testDiskName)->put($this->fileName, 'test file content');

        $url = $this->repository->getUrl($this->fileName);

        $this->assertStringContainsString($this->fileName, $url);
    }

    public function testFileExists(): void
    {
        Storage::disk($this->testDiskName)->put($this->fileName, 'test file content');
        $exists = $this->repository->fileExists($this->fileName);
        $this->assertTrue($exists);
    }

    public function testSaveFile(): void
    {
        $file = UploadedFile::fake()->create('test.jpg', 100);
        $this->repository->saveFile($file);
        Storage::disk($this->testDiskName)->assertExists($file->hashName());
    }

    public function testDeleteFile(): void
    {
        Storage::disk($this->testDiskName)->put($this->fileName, 'test file content');
        $this->repository->deleteFile($this->fileName);
        Storage::fake($this->testDiskName)->assertMissing($this->fileName);
    }

}

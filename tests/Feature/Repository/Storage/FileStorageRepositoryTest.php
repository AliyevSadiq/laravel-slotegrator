<?php

namespace Tests\Feature\Repository\Storage;

use App\Repository\Storage\FileStorageRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileStorageRepositoryTest extends TestCase
{

    private FileStorageRepository $repo;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repo = new FileStorageRepository();
        $this->repo->setDiskName('test');
    }

    public function testGetUrl()
    {
        Storage::fake('test');
        $filename = 'test.txt';
        Storage::disk('test')->put($filename, 'Test File Content');
        $url = $this->repo->getUrl($filename);
        $this->assertEquals(Storage::disk('test')->url($filename), $url);
    }


    public function testFileExists()
    {
        Storage::fake('test');
        $filename = 'test.txt';
        Storage::disk('test')->put($filename, 'Test File Content');
        $exists = $this->repo->fileExists($filename);
        $this->assertTrue($exists);
    }

    public function testSaveFile()
    {
        Storage::fake('test');
        $file = UploadedFile::fake()->create('test.txt', 100);
        $this->repo->saveFile($file);
        Storage::disk('test')->assertExists($file->hashName());
    }

    public function testDeleteFile()
    {
        Storage::fake('test');
        $filename = 'test.txt';
        Storage::disk('test')->put($filename, 'Test File Content');
        $this->repo->deleteFile($filename);
        Storage::disk('test')->assertMissing($filename);
    }
}

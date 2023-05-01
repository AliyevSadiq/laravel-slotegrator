<?php

declare(strict_types=1);

namespace App\Repository\Storage;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

final class AWSStorageRepository implements StorageRepositoryInterface
{
    private string $diskName;

    public function setDiskName(string $name): self
    {
        $this->diskName = $name;
        return $this;
    }

    public function getUrl(string $filename): string
    {
        return Storage::disk($this->diskName)->temporaryUrl($filename, now()->addMinutes(30));
    }

    public function fileExists(string $filename): bool
    {
        return Storage::disk($this->diskName)->exists($filename);
    }

    public function saveFile(UploadedFile $file)
    {
        return Storage::disk($this->diskName)->put('', $file);
    }

    public function deleteFile(string $filename): void
    {
        Storage::disk($this->diskName)->delete($filename);
    }
}

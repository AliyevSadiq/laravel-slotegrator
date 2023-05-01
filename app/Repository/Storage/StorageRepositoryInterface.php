<?php


namespace App\Repository\Storage;


use Illuminate\Http\UploadedFile;

interface StorageRepositoryInterface
{
    public function setDiskName(string $name):self;
    public function getUrl(string $filename):string;
    public function fileExists(string $filename):bool;
    public function saveFile(UploadedFile $file);
    public function deleteFile(string $filename):void;
}

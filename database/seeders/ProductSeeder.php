<?php

namespace Database\Seeders;

use App\Enums\DiskName;
use App\Models\Product;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->reCreateDirectory('public/product/image');

        Product::factory(100)->create()->each(function ($product){
            $product->images()->create([
                'disk_name'=>DiskName::PRODUCT,
                'image'=>Factory::create()->image(storage_path('app/public/product/image'), 400, 300, null, false)
            ]);
        });
    }

    private function reCreateDirectory(string $path)
    {
        if (!Storage::exists($path)) {
            Storage::makeDirectory($path);
        } else {
            $files = Storage::allFiles($path);
            if (count($files) > 0) {
                Storage::delete($files);
            }
        }
    }
}

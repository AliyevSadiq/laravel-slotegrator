<?php

namespace Tests\Feature\Repository;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Repository\ProductRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class ProductRepositoryTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase;

    public function testAllProducts()
    {
        $category = Category::factory()->create();
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'user_id' => $user->id,
        ]);

        $request = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock();

        $productRepo = $this->getMockBuilder(ProductRepository::class)
            ->onlyMethods(['allProducts'])
            ->getMock();

        $productRepo->method('allProducts')
            ->willReturn($product);

        $query = $productRepo->allProducts($request);

        $this->assertEquals(1, $query->count());
    }
}

<?php

namespace Tests\Feature\Repository;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Repository\FavoriteRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class FeatureRepositoryTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        Auth::login($this->user);
    }

    public function test_is_authenticated()
    {
        $this->assertAuthenticated();
    }

    public function testList()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'user_id' => $this->user->id,
        ]);

        $favorite = $this->user->favorites()->create([
            'product_id' => $product->id
        ]);


        $request = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock();

        $favoriteRepo = $this->getMockBuilder(FavoriteRepository::class)
            ->onlyMethods(['list'])
            ->getMock();

        $favoriteRepo->method('list')
            ->willReturn($favorite);

        $query = $favoriteRepo->list($request);

        $this->assertEquals(1, $query->count());
    }
}

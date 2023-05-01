<?php

namespace Tests\Feature\CommandBus\API\Favorite\Handlers;

use App\CommandBus\API\Favorite\Commands\StoreFavoriteCommand;
use App\CommandBus\API\Favorite\Handlers\StoreFavoriteHandler;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreFavoriteHandlerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    private User $user;


    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    /**
     * A basic feature test example.
     */
    public function test_store_favorite_handle(): void
    {
        $product = Product::factory()->create();

        $command = new StoreFavoriteCommand();

        $command->handlePayload([
            'product' => $product
        ]);

        $handle = new StoreFavoriteHandler();

        $handle->handle($command);


        $this->assertNotEmpty($command->product);
        $this->assertEquals($command->product->id, $product->id);
        $this->assertTrue($this->user->favorites->contains($product->id));
    }
}

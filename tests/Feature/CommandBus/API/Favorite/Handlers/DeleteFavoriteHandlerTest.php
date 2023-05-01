<?php

namespace Tests\Feature\CommandBus\API\Favorite\Handlers;

use App\CommandBus\API\Favorite\Commands\DeleteFavoriteCommand;
use App\CommandBus\API\Favorite\Commands\StoreFavoriteCommand;
use App\CommandBus\API\Favorite\Handlers\DeleteFavoriteHandler;
use App\CommandBus\API\Favorite\Handlers\StoreFavoriteHandler;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteFavoriteHandlerTest extends TestCase
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
    public function test_delete_favorite_handle(): void
    {
        $product = Product::factory()->create();

        $favorite=$this->user->favorites()->create([
            'product_id'=>$product->id
        ]);

        $command=new DeleteFavoriteCommand();

        $command->handlePayload([
            'favorite'=>$favorite
        ]);

        $handle=new DeleteFavoriteHandler();

        $handle->handle($command);

        $this->assertNotEmpty($command->favorite);

        $this->assertEmpty($this->user->favorites);
    }
}

<?php

namespace Tests\Feature\CommandBus\API\Auth\Handlers;

use App\CommandBus\API\Auth\Commands\LoginCommand;
use App\CommandBus\API\Auth\Handlers\LoginHandler;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class LoginHandlerTest extends TestCase
{
    use WithFaker,RefreshDatabase;

    private User $user;


   protected function setUp(): void
   {
       parent::setUp(); // TODO: Change the autogenerated stub
       $this->user=User::factory()->create();
   }


    public function test_login_handler_should_return_token_for_valid_credentials()
    {
        // Arrange
        $user = $this->user;

        $command = new LoginCommand();

        $command->handlePayload([
            'email' => $user->email,
            'password' => 'password',
        ]);

        $handler = new LoginHandler();

        // Act
        $handler->handle($command);

        $this->assertNotNull($command->token);
        $this->assertNotEmpty($command->token);
        $this->assertTrue($user->tokens()->exists());
        $this->assertEquals($user->tokens()->first()->name, 'apiToken');
    }


    public function test_it_throws_exception_with_invalid_credentials()
    {
        // Arrange
        $user=$this->user;
        $command = new LoginCommand();

        $command->handlePayload([
            'email' => $user->email,
            'password' => 'wrong_password',
        ]);

        $handler = new LoginHandler();

        // Assert
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Incorrect username or password');
        $this->expectExceptionCode(Response::HTTP_UNAUTHORIZED);

        // Act
        $handler->handle($command);
    }


}

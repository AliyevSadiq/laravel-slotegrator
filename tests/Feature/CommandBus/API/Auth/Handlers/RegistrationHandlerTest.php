<?php

namespace Tests\Feature\CommandBus\API\Auth\Handlers;

use App\CommandBus\API\Auth\Commands\LoginCommand;
use App\CommandBus\API\Auth\Commands\RegistrationCommand;
use App\CommandBus\API\Auth\Handlers\LoginHandler;
use App\CommandBus\API\Auth\Handlers\RegistrationHandler;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegistrationHandlerTest extends TestCase
{
    use WithFaker,RefreshDatabase;

    public function test_registration_handle_creates_user_with_hashed_password()
    {
        // Arrange
        $name = 'Test User';
        $email = 'test@example.com';
        $password = 'password';

        $command = new RegistrationCommand();

        $command->handlePayload([
            'name'=>$name,
            'email'=>$email,
            'password'=>$password
        ]);

        $handler = new RegistrationHandler();

        // Act
        $handler->handle($command);

        // Assert
        $user = User::where('email', $email)->firstOrFail();

        $this->assertEquals($name, $user->name);
        $this->assertEquals($email, $user->email);
        $this->assertTrue(Hash::check($password, $user->password));
    }


}

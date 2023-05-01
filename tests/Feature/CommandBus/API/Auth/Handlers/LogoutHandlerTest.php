<?php

namespace Tests\Feature\CommandBus\API\Auth\Handlers;

use App\CommandBus\API\Auth\Commands\LoginCommand;
use App\CommandBus\API\Auth\Commands\LogoutCommand;
use App\CommandBus\API\Auth\Handlers\LoginHandler;
use App\CommandBus\API\Auth\Handlers\LogoutHandler;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use Tests\TestCase;

class LogoutHandlerTest extends TestCase
{
    use WithFaker,RefreshDatabase;

    public function test_handle_method_deletes_all_tokens_of_user()
    {
        $user = User::factory()->create();
        Auth::login($user);

        $token = $user->createToken('test-token')->plainTextToken;

        $command = new LogoutCommand();
        $handler = new LogoutHandler();
        $handler->handle($command);

        $this->assertCount(0, PersonalAccessToken::where('token', $token)->get());
    }





}

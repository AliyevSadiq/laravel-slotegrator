<?php

namespace App\Http\Controllers\Api;

use App\CommandBus\API\Auth\Commands\LoginCommand;
use App\CommandBus\API\Auth\Commands\LogoutCommand;
use App\CommandBus\API\Auth\Commands\RegistrationCommand;
use App\CommandBus\Core\Contract\CommandBusInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegistrationRequest;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(private CommandBusInterface $commandBus)
    {
    }

    /**
     * @OA\Post(
     *      tags={"Auth"},
     *      path="/api/login",
     *      operationId="login",
     *      summary="Login",
     *      description="User log In and return generated token",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema (ref="#/components/schemas/UserLoginRequest")
     *          ),
     *          @OA\JsonContent(ref="#/components/schemas/UserLoginRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *          @OA\JsonContent()
     *      )
     * )
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try{
            $command=new LoginCommand();
            $this->commandBus->dispatch($command,$request->all());

            return $this->jsonSuccess('User authorized',[
               'token'=>$command->token
            ]);
        }catch (\Exception $exception){
            return $this->jsonError($exception->getMessage())->setStatusCode($exception->getCode());
        }
    }


    /**
     * @OA\Post(
     *      tags={"Auth"},
     *      path="/api/auth/logout",
     *      operationId="logout",
     *      summary="Logout",
     *      description="User logout",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent()
     *      ),
     *     security={{"sanctum":{}}},
     * )
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        try{
            $command=new LogoutCommand();
            $this->commandBus->dispatch($command);

            return $this->jsonSuccess('User logout');
        }catch (\Exception $exception){
            return $this->jsonError($exception->getMessage());
        }
    }

    /**
     * @OA\Post(
     *      tags={"Auth"},
     *      path="/api/registration",
     *      operationId="registration",
     *      summary="Registration",
     *      description="User registration",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema (ref="#/components/schemas/UserRegistrationRequest")
     *          ),
     *          @OA\JsonContent(ref="#/components/schemas/UserRegistrationRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *          @OA\JsonContent()
     *      )
     * )
     * @return JsonResponse
     */
    public function registration(RegistrationRequest $request): JsonResponse
    {
        try{
            $command=new RegistrationCommand();
            $this->commandBus->dispatch($command,$request->all());
            return $this->jsonSuccess('User registered');
        }catch (\Exception $exception){
            return $this->jsonError($exception->getMessage())->setStatusCode($exception->getCode());
        }
    }
}

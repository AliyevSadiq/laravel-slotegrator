<?php

declare(strict_types=1);

namespace App\Virtual\Request\Auth;

/**
 * @OA\Schema(
 *      title="User Log In request",
 *      description="User Login request body data",
 *      type="object",
 *      required={"email", "password"}
 * )
 */
class UserLoginRequest
{


    /**
     * @OA\Property(
     *      title="email",
     *      description="Email",
     *      example="test@bk.ru"
     * )
     *
     * @var string
     */
    public string $email;

    /**
     * @OA\Property(
     *      title="password",
     *      description="User password",
     *      example="password"
     * )
     *
     * @var string
     */
    public string $password;
}

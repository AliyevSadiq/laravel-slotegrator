<?php

declare(strict_types=1);

namespace App\Virtual\Request\Auth;

/**
 * @OA\Schema(
 *      title="User Registration request",
 *      description="User Registration request body data",
 *      type="object",
 *      required={"email","name", "password","password_confirmation"}
 * )
 */
class UserRegistrationRequest
{

    /**
     * @OA\Property(
     *      title="name",
     *      description="Name",
     *      example="username"
     * )
     *
     * @var string
     */
    public string $name;

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

    /**
     * @OA\Property(
     *      title="password_confirmation",
     *      description="User password_confirmation",
     *      example="password"
     * )
     *
     * @var string
     */
    public string $password_confirmation;
}

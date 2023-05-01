<?php

namespace Tests\Feature\Http\Requests\Api;

use App\Http\Requests\Api\LoginRequest;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginRequestTest extends TestCase
{

    use WithFaker,RefreshDatabase;

    /**
     * @var LoginRequest
     */
    private $rules;

    /** @var \Illuminate\Validation\Validator */
    private $validator;

    public function setUp(): void
    {
        parent::setUp();
        $this->validator = app()->get('validator');
        $this->rules = (new LoginRequest())->rules();
    }

    public function validationProvider()
    {
        $faker = Factory::create(Factory::DEFAULT_LOCALE);
        $email = $faker->email;
        $password = 'password';

        return [
            'request_should_fail_when_no_email_is_provided' => [
                'passed' => false,
                [
                    'password' => $password
                ]
            ],
            'request_should_fail_when_no_password_is_provided' => [
                'passed' => false,
                [
                    'email' => $email,
                ]
            ],
            'request_should_fail_when_email_is_invalid' => [
                'passed' => false,
                [
                    'email' => 'email',
                    'password' => $password,
                ]
            ],
            'request_should_success_when_all_fields_valid' => [
                'passed' => true,
                [
                    'email' => $email,
                    'password' => $password,
                ]
            ],
        ];
    }
    /**
     * @test
     * @dataProvider validationProvider
     * @param bool $shouldPass
     * @param array $mockedRequestData
     */
    public function validation_results_as_expected($shouldPass, $mockedRequestData)
    {
        $this->assertEquals(
            $shouldPass,
            $this->validate($mockedRequestData)
        );
    }

    protected function validate($mockedRequestData)
    {
        return $this->validator->make($mockedRequestData, $this->rules)
            ->passes();
    }
}

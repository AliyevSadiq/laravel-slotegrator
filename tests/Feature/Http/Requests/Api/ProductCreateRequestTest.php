<?php

namespace Tests\Feature\Http\Requests\Api;

use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\ProductCreateRequest;
use App\Models\Category;
use App\Models\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ProductCreateRequestTest extends TestCase
{

    use RefreshDatabase,DatabaseMigrations,WithFaker;

    /**
     * @var ProductCreateRequest()
     */
    private $rules;

    private User $user;
    private Category $category;

    /** @var \Illuminate\Validation\Validator */
    private $validator;

    public function setUp(): void
    {
        parent::setUp();
        $this->validator = app()->get('validator');
        $this->rules = (new ProductCreateRequest())->rules();

        $this->user=User::factory()->create();
        Auth::login($this->user);
    }


    public function test_is_authenticated()
    {
        $this->assertAuthenticated();
        $this->assertAuthenticatedAs($this->user);
    }



    public function validationProvider()
    {
        $faker = Factory::create(Factory::DEFAULT_LOCALE);

        $name=$faker->name;
        $description=$faker->text;
        $category_id=1;
        $image=UploadedFile::fake()->create('image.jpg');

        return [
            'request_should_fail_when_no_name_is_provided' => [
                'passed' => false,
                [
                    'description' => $description,
                    'category_id' => $category_id,
                    'images' => $image,
                ]
            ],
            'request_should_fail_when_no_description_is_provided' => [
                'passed' => false,
                [
                    'name' => $name,
                    'category_id' => $category_id,
                    'images' => $image,
                ]
            ],
            'request_should_fail_when_no_category_id_is_provided' => [
                'passed' => false,
                [
                    'name' => $name,
                    'description' => $description,
                    'images' => $image,
                ]
            ],
            'request_should_fail_when_no_image_is_provided' => [
                'passed' => false,
                [
                    'name' => $name,
                    'description' => $description,
                    'category_id' => $category_id,
                ]
            ],
            'request_should_fail_when_no_image_is_invalid' => [
                'passed' => false,
                [
                    'name' => $name,
                    'description' => $description,
                    'category_id' => $category_id,
                    'images' => UploadedFile::fake()->image('document.pdf'),
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

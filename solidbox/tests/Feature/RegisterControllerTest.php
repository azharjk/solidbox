<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    const REGISTER_ROUTE_NAME = 'register';

    public function registerOkResponse()
    {
        return $this->post(route(self::REGISTER_ROUTE_NAME), [
            'name' => 'Muhammad Azhari',
            'username' => 'azharazhar1010',
            'password' => 'johndoe123'
        ]);
    }

    public function test_registration_should_throw_bad_request_http_exception_when_request_is_not_satisfy_the_validator()
    {
        $response = $this->post(route(self::REGISTER_ROUTE_NAME), [
            'name' => 'Muhammad Azhari',
            'username' => 'aaa',
            'password' => 'johndoe123'
        ]);

        $response->assertStatus(400);
    }

    public function test_registration_should_add_user_to_database()
    {
        $this->registerOkResponse();

        $this->assertDatabaseHas('users', [
            'username' => 'azharazhar1010'
        ]);
    }

    public function test_registration_should_create_token()
    {
        $this->registerOkResponse();

        $userId = User::latest()->first()->id;

        $this->assertDatabaseHas('personal_access_tokens', [
            'tokenable_id' => $userId
        ]);
    }

    public function test_registration_should_response_with_json_data()
    {
        $response = $this->registerOkResponse();

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'token'
                ]
            ]);
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

use App\Http\Controllers\LoginController;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    const LOGIN_ROUTE_NAME = 'login';

    private $controller;

    public function setUp(): void
    {
        parent::setUp();

        $this->controller = new LoginController;
    }

    public function test_isValidCredential_should_return_null_when_user_not_exists()
    {
        $user = $this->controller->isValidCredential([
            'username' => 'azharazhar1010',
            'password' => 'helloguys9010'
        ]);

        $this->assertNull($user);
    }

    public function test_isValidCredential_should_return_null_when_password_incorrect()
    {
        User::factory()->create([
            'username' => 'azharazhar1010',
        ]);

        $user = $this->controller->isValidCredential([
            'username' => 'azharazhar1010',
            'password' => 'invalidpassword123'
        ]);

        $this->assertNull($user);
    }

    public function test_isValidCredential_should_return_user_when_valid()
    {
        User::factory()->create([
            'username' => 'azharazhar1010',
            'password' => Hash::make('password')
        ]);

        $user = $this->controller->isValidCredential([
            'username' => 'azharazhar1010',
            'password' => 'password'
        ]);

        $this->assertNotNull($user);
    }

    public function test_should_response_with_code_400_when_validator_fails()
    {
        $response = $this->post(route(self::LOGIN_ROUTE_NAME));

        $response->assertStatus(400);
    }

    public function test_should_response_with_incorrect_creds_message_when_creds_not_valid()
    {
        User::factory()->create([
            'username' => 'azharazhar1010'
        ]);

        $response = $this->post(route(self::LOGIN_ROUTE_NAME), [
            'username' => 'azharazhar1010',
            'password' => 'somethingonlyweknow'
        ]);

        $response->assertStatus(200)->assertJson([
            'message' => 'Incorrect credential'
        ]);
    }

    public function test_should_create_token()
    {
        $user = User::factory()->create([
            'username' => 'azharazhar1010'
        ]);

        $this->post(route(self::LOGIN_ROUTE_NAME), [
            'username' => 'azharazhar1010',
            'password' => 'password'
        ]);

        $this->assertDatabaseHas('personal_access_tokens', [
            'tokenable_id' => $user->id
        ]);
    }
}

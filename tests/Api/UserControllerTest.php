<?php

namespace Tests\Api;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    private string $token;
    private const EMAIL = 'user@test.com';
    private const PASSWORD = 'password';
    private const NAME = 'UserControllerTest';

    public function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create(['password' => Hash::make(self::PASSWORD)]);
        $response = $this->postJson('api/login', [
            'email' => $user->email,
            'password' => self::PASSWORD
        ]);
        $this->token = json_decode($response->getContent(), true)['token'];
    }

    public function testIndexReturnsDataInValidFormat()
    {
        $response = $this->withToken($this->token)->get('api/users');
        $response->assertOk()->assertJsonStructure([
            [
                'id',
                'name',
                'email',
                'email_verified_at',
                'created_at',
                'updated_at',
            ]
        ]);
    }

    public function testSuccessCreateUser()
    {
        $response = $this->withToken($this->token)->post('api/users', [
            'name' => "1_" . self::NAME,
            'email' => "1_" . self::EMAIL,
            'password' => self::PASSWORD
        ]);
        $response->assertCreated();
        $this->assertDatabaseHas('users', [
            'name' => "1_" . self::NAME,
            'email' => "1_" . self::EMAIL,
        ]);
    }

    public function testDuplicateEmailErrorWhileCreatingUser()
    {
        User::factory()->create(['email' => self::EMAIL]);
        $response = $this->withToken($this->token)->post('api/users', [
            'name' => self::NAME,
            'email' => self::EMAIL,
            'password' => self::PASSWORD
        ]);
        $response->assertUnprocessable()->assertJson([
            "errors" => [
                "email" => [
                    "The email has already been taken."
                ]
            ]
        ]);
    }

    public function testUpdateUser()
    {
        $user = User::factory()->create();
        $this->assertDatabaseHas('users', [
            'name' => $user->name,
            'email' => $user->email,
        ]);

        $response = $this->withToken($this->token)->put('api/users/' . $user->id, [
            'name' => 'changed_name'
        ]);
        $response->assertOk()->assertJson([
            'name' => 'changed_name',
            'email' => $user->email,
        ]);
        $this->assertDatabaseHas('users', [
            'name' => 'changed_name',
            'email' => $user->email,
        ]);
    }

    public function testDeleteUser()
    {
        $user = User::factory()->create();
        $response = $this->withToken($this->token)->delete('api/users/' . $user->id);
        $response->assertNoContent();
        $this->assertDatabaseMissing('users', [
            'name' => $user->name,
            'email' => $user->email
        ]);
    }

    public function testShowUser()
    {
        $user = User::factory()->create();
        $response = $this->withToken($this->token)->get('api/users/' . $user->id);
        $response->assertOk()->assertJson([
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }
}

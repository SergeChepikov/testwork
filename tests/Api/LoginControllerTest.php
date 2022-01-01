<?php

namespace Tests\Api;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    private const EMAIL = 'login@test.com';
    private const PASSWORD = 'password';

    public function setUp(): void
    {
        parent::setUp();
        User::factory()->create([
            'email' => self::EMAIL,
            'password' => Hash::make(self::PASSWORD)
        ]);
    }

    public function testCorrectLogin()
    {
        $this->json('post', 'api/login', [
            'email' => self::EMAIL,
            'password' => self::PASSWORD
        ])->assertStatus(Response::HTTP_OK)->assertJsonStructure(['token']);
    }

    public function testIncorrectLogin()
    {
        $this->json('post', 'api/login', [
            'email' => self::EMAIL,
            'password' => "incorrect-password"
        ])->assertStatus(Response::HTTP_FORBIDDEN);
    }
}

<?php

namespace Tests;

use App\Models\User;
use Exception;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations;

    private Generator $faker;

    public function setUp()    : void {
        parent::setUp();
        $this->faker = Factory::create();
        Artisan::call('migrate');
        Artisan::call('migrate:refresh');
    }

    public function __get($key) {
        if ($key === 'faker') {
            return $this->faker;
        }
        throw new Exception('Unknown Key Requested');
    }
}
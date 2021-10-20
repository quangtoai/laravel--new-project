<?php

namespace Tests\Unit\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Tests\Unit\Session;
use Faker\Factory as Faker;

class UserUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->faker = Faker::create();

        $this->users = [

            'emp_name' => $this->faker->name,
            'emp_code' => 123456,
            'email' => 'test@gmail.com',
            'password' => Hash::make('123456789'),
            'is_new_pw' => '1',
            'proxy_email' => $this->faker->email,
            'retirement_at' => $this->faker->date,
            'role' => $this->faker->name,

        ];

        $this->param = [
            'emp_code' => '123456',
            'password' => '123456789',
        ];
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * A basic unit test example 1.
     *
     * @return void
     */
    /** @test */
    public function testUpDateSuccessfully()
    {
        $response = $this->call('PUT', 'api/user/888888', [
            "email" => $this->faker->email,
            "proxy_email" => "mail1@gmail.com",
            "password" => "123456789"
        ]);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testUpdateNotHaveParams()
    {
        $response = $this->call('PUT', 'api/auth/update', [
            "email" => "",
            "proxy_email" => "",
            "password" => ""
        ]);
        $this->assertEquals(405, $response->decodeResponseJson()['code']);
    }

    public function testUpdateNotEmail()
    {
        $response = $this->call('PUT', 'api/auth/update', [
            "email" => "",
            "proxy_email" => $this->faker->email,
            "password" => "123456789"
        ]);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testUpdateNotProxy()
    {
        $response = $this->call('PUT', 'api/auth/update', [
            "email" => $this->faker->email,
            "proxy_email" => "",
            "password" => "123456789"
        ]);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testUpdateNotProxyEmail()
    {
        $response = $this->call('PUT', 'api/auth/update', [
            "email" => "",
            "proxy_email" => "",
            "password" => "123456789"
        ]);
        $this->assertEquals(405, $response->decodeResponseJson()['code']);
    }

    public function testUpdateNotPass()
    {
        $response = $this->call('PUT', 'api/auth/update', [
            "email" => $this->faker->email,
            "proxy_email" => $this->faker->email,
            "password" => "",
        ]);
        $this->assertEquals(405, $response->decodeResponseJson()['code']);
    }

    public function testUpdateErrorEmail()
    {
        $response = $this->call('PUT', 'api/auth/update', [
            "email" => "testgmail.com",
            "proxy_email" => $this->faker->email,
            "password" => "123456789",
        ]);
        $this->assertEquals('405', $response->decodeResponseJson()['code']);
    }

    public function testUpdatErrorRequestPass()
    {
        $response = $this->call('PUT', 'api/auth/update', [
            "email" => $this->faker->email,
            "proxy_email" => $this->faker->email,
            "password" => "12789",
        ]);
        $this->assertEquals('405', $response->decodeResponseJson()['code']);
    }

}

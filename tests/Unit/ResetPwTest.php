<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Facade;
use Tests\TestCase;
use Faker\Factory as Faker;

class ResetPwTest extends TestCase
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
            'password' => '123456789',
            'is_new_pw' => '1',
            'proxy_email' => $this->faker->email,
            'retirement_at' => $this->faker->date,
            'role' => 'MANAGER',

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
    public function testResetPassWordSuccessfully()
    {
        $response = $this->call('POST', 'api/remind-passwords', [
            'emp_code' => '666888',
            '_token' => csrf_token()
        ]);
        $this->assertEquals(true,$response->getStatusCode(),'Submit request successfully');

    }

    public function testResetPassWordTimeout()
    {
        $response = $this->call('POST', 'api/remind-passwords', [
            'emp_code' => '123456',
            '_token' => csrf_token()
        ]);
        $response->assertJson(["message" => "server.emp_code_not_exist"]);
    }

    public function testResetNotHavePassword()
    {
        $response = $this->postJson('api/remind-passwords', [
            'emp_code' => '',
            '_token' => csrf_token()
        ]);
        $response->assertJson(["message" => "server.emp_code_not_exist"]);
    }


    public function testResetPassWordWrongCode()
    {
        $response = $this->postJson('api/remind-passwords', [
            'emp_code' => '12345',
            '_token' => csrf_token()
        ]);
        $response->assertJson(["message" => "server.emp_code_not_exist"]);
    }

}

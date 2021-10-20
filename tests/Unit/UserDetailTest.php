<?php

namespace Tests\Unit;

use App\Http\Controllers\Api\UserController;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Faker\Factory as Faker;
use Illuminate\Foundation\Application;
use Symfony\Component\HttpFoundation\Request;
use Tests\TestCase;
use App\Repositories\UserRepository;
use Mockery as m;
use Illuminate\Foundation\Testing\WithFaker;

class UserDetailTest extends TestCase
{
    protected $user;
    protected $param;
    protected $userRepository;
    /**
     * @var UserController
     */
    protected $userController;
    protected $repository;
    protected $userRequest;

    use WithFaker;

    public function setUp(): void
    {
        $app = new Application();
        $userRepository = new UserRepository($app);

        $this->afterApplicationCreated(function () use ($userRepository) {
            $this->userRepository = m::mock($userRepository)->makePartial();
            $this->userController = new UserController(
                $this->app->instance(UserRepositoryInterface::class, $this->userRepository)
            );
        });
        $this->userRequest = new UserRequest();
        $this->faker = Faker::create();

        // chuẩn bị dữ liệu test
        $this->user = [
            'last_name' => $this->faker->name,
            'first_name' => $this->faker->name,
            'emp_code' => 123456,
            'email' => 'test@gmail.com',
            'password' => '$2y$10$4r1hyk5fjqUpm13SxXLXiOslUe3wWGHp5eONTlQWyJ1hy3gLSGSMC',
            'is_new_pw' => '1',
            'proxy_email' => $this->faker->email,
            'retirement_at' => $this->faker->date,
        ];
//        $this->param = [
//          'username'=> 'test25@gmail.com',
//          'password'=> '12345678',
//        ];
        parent::setUp();

    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * test User.
     * @param UserRequest $this- >param
     * @param null $guard
     * @return void
     */

    public function testUserShowID()
    {
        $this->userRequest->merge($this->user);
        $user = User::factory()->create();
        $response = $this->userController->show($user->id);
        $this->assertEquals(true ,$response->getStatusCode());
    }

    public function testUserDestroy()
    {
        $this->userRequest->merge($this->user);
        $user = User::factory()->create();
        $response = $this->userController->destroy($user->id);
        $this->assertEquals(true ,$response->getStatusCode());
    }

}

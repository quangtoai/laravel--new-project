<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Support\Facades\Facade;
use Symfony\Component\HttpFoundation\Request;
use Tests\TestCase;
use Faker\Factory as Faker;
use Repository\AuthRepository;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;

class LoginTest extends TestCase
{
    protected $request;
    protected $authRepository;
    protected $loginRequest;
    protected $user;
    protected $param;

    public function setUp(): void{
        parent::setUp();
        Facade::clearResolvedInstances();
        $this->faker = Faker::create();

        $this->user = [
            'emp_name' => $this->faker->name,
            'emp_code' => 123456,
            'email' => 'test@gmail.com',
            'password' => Hash::make('123456789'),
            'is_new_pw' => '1',
            'proxy_email' => $this->faker->email,
            'retirement_at' => $this->faker->date,
            'role' => $this->faker->name,
        ];
        $this->request = new LoginRequest();
        $this->authRepository = new AuthRepository();
        $this->loginRequest = new LoginRequest();
    }
    public function tearDown(): void
    {
        parent::tearDown();
    }

    public function testLogin(){
        // Gọi hàm tạo
        $param = [
            'emp_code' => '123456',
            'password' => '123456789',
        ];
        $this->request->merge($param);
        $response = $this->authRepository->doLogin($this->request, $guard = null);
        //check if the object is checked
        $this->assertInstanceOf(User::class, $response['user']);
        //Check if you can check the data or not
        $this->assertEquals($param['emp_code'], $response['user']->emp_code);
    }
    public function testLoginWrongCodeOrPass(){
        $param = [
            'emp_code' => '12345655',
            'password' => '1234567',
        ];
        $this->request->merge($param);
        $response = $this->authRepository->doLogin($this->request, $guard = null);
        $this->assertEquals(false, $response['attempt'],
            'The emp code may not be greater than 6 characters.');
    }
    public function testLoginNotHavePassword(){
        $param = [
            'emp_code' => '123456',
            'password' => '',
        ];
        $this->request->merge($param);
        $response = $this->authRepository->doLogin($this->request, $guard = null);
        // dd($response);
        $this->assertEquals(false, $response['attempt'],
            'The パスワード field is required.');
    }
    public function testLoginNotHaveParams(){
        $param = [
            'emp_code' => '',
            'password' => '',
        ];
        $this->request->merge($param);
        $response = $this->authRepository->doLogin($this->request, $guard = null);
        $this->assertEquals(false, $response['attempt'],
            'The emp code field is required.');
    }
    public function testLoginWrongTypeCode(){
        $param = [
            'user_name' => '1234@12',
            'password' => '',
        ];
        $this->request->merge($param);
        $response = $this->authRepository->doLogin($this->request, $guard = null);
        $this->assertEquals(false, $response['attempt'],
            'The emp code may only contain letters, numbers, dashes and underscores.');
    }
    public function testLoginNotHaveEmailOrPhoneNumber(){
        $param = [
            'emp_code' => '',
            'password' => '123456789',
        ];
        $this->request->merge($param);
        $response = $this->authRepository->doLogin($this->request, $guard = null);
        $this->assertEquals(false, $response['attempt'],
            'The emp code field is required.');
    }
    public function testLoginCrewSuccessful(){
        $param = [
            'emp_code' => '888888',
            'password' => '123456789',
        ];
        $this->request->merge($param);
        $response = $this->authRepository->doLogin($this->request, $guard = null);
        $this->assertEquals($param['emp_code'], $response['user']->emp_code);
    }
    public function testLoginManagerSuccessful(){
        $param = [
            'emp_code' => '123456',
            'password' => '123456789',
        ];
        $this->request->merge($param);
        $response = $this->authRepository->doLogin($this->request, $guard = null);
        $this->assertEquals($param['emp_code'], $response['user']->emp_code);
    }

}

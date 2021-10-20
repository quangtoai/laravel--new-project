<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\WithFaker;
class UserSeeder extends Seeder
{
    use WithFaker;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!User::find(1)) {
            User::insert([

                ['id' => 1,
                    'emp_code' => '123456',
                    'email' => 'testveho123456@gmail.com',
                    'password' => Hash::make('123456789'),
                    'temp_pass' => '12341234',
                    'retirement_at' => null,
                    'first_name' => 'Admin',
                    'last_name' => '',
                    'is_new_pw' => '0',
                    'role' => 'MANAGER',
                    'proxy_email' => 'proxyemail@gmail.com'
                ],
                [
                    'id' => 2,
                    'emp_code' => '555555',
                    'email' => 'veho4649555@gmail.com',
                    'password' => Hash::make('123456789'),
                    'temp_pass' => '12341234',
                    'retirement_at' => '2021/07/10',
                    'first_name' => 'satoshi',
                    'last_name' => 'nakamoto',
                    'is_new_pw' => '1',
                    'role' => 'CREW',
                    'proxy_email' => 'hovantoai92@gmail.com',
                ],
                [
                    'id' => 3,
                    'emp_code' => '888888',
                    'email' => 'test123.qsoft@gmail.com',
                    'password' => Hash::make('123456789'),
                    'temp_pass' => '12341234',
                    'retirement_at' => null,
                    'first_name' => 'pigion',
                    'last_name' => 'nakamoto',
                    'is_new_pw' => '1',
                    'role' => 'CREW',
                    'proxy_email' => 'veho4649555@gmail.com'
                ],
                [
                    'id' => 4,
                    'emp_code' => '1234',
                    'email' => null,
                    'password' => Hash::make('123456789'),
                    'temp_pass' => '12341234',
                    'retirement_at' => null,
                    'first_name' => 'David crew',
                    'last_name' => '',
                    'is_new_pw' => '1',
                    'role' => 'CREW',
                    'proxy_email' => 'baotuyen555@gmail.com'
                ],
                [
                    'id' => 5,
                    'emp_code' => '666888',
                    'email' => null,
                    'password' => Hash::make('123456789'),
                    'temp_pass' => '12341234',
                    'retirement_at' => null,
                    'first_name' => 'Shin',
                    'last_name' => '',
                    'is_new_pw' => '1',
                    'role' => 'CREW',
                    'proxy_email' => 'shintest@gmail.com'
                ]
            ]);
        }

        $this->faker = Faker::create();
        for ($i = 1; $i < 100; $i++) {
            User::insert([
                [
                    'emp_code' => rand(111111, 999999),
                    'email' => $this->faker->email,
                    'password' => Hash::make('123456789'),
                    'temp_pass' =>$this->faker->password(8,20),
                    'retirement_at' =>$this->faker->date,
                    'first_name' => $this->faker->firstName,
                    'last_name' => $this->faker->lastName,
                    'is_new_pw' => rand(0, 1),
                    'role' => 'MANAGER',
                    'proxy_email' => $this->faker->email
                ],
            ]);
        }
    }
}

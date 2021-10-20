<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'last_name' => $this->faker->name,
            'first_name' => $this->faker->name,
            'emp_code' => 123456,
            'email' => 'test@gmail.com',
            'password' => Hash::make('123456789'),
            'is_new_pw' => '1',
            'proxy_email' => $this->faker->email,
            'retirement_at' => $this->faker->date,
        ];
    }
}

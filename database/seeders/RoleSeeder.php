<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!Role::find(1)) {
            Role::insert([
                [
                    'id' => 1,
                    'name' => 'CREW',
                    'code' => 'CREW',
                    'level' => '1',
                ],
                [
                    'id' => 2,
                    'name' => 'MANAGER',
                    'code' => 'MANAGER',
                    'level' => '2',
                ]
            ]);
        }
    }
}

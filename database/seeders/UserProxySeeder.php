<?php

namespace Database\Seeders;

use App\Models\UserProxy;
use Illuminate\Database\Seeder;

class UserProxySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!UserProxy::find(1)) {
            UserProxy::insert([
                [
                    'id' => 1,
                    'name' => '中村本部長',
                    'email' => 'izumi_nakamura@izumibuturyu.com',
                ],
                [
                    'id' => 2,
                    'name' => '伊藤部長',
                    'email' => 'itou_yuuma@izumibuturyu.com',
                ],
                [
                    'id' => 3,
                    'name' => 'David_test',
                    'email' => 'baotuyen555@gmail.com',
                ]
            ]);
        }
    }
}

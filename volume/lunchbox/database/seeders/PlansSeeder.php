<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Plan::insert([
            ['name' => '通常ランチ', 'reserve_limit_h' => 1, 'created_at' => date('Y-m-d H:i:s')],
            ['name' => '極ランチ', 'reserve_limit_h' => 7, 'created_at' => date('Y-m-d H:i:s')],
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\User;
use App\Models\Order;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(30)->create();
        Plan::factory(2)->create();
        Order::factory(360)->create();
    }
}

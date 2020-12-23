<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrdersSheet;
use App\Models\User;
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
        $this->call(PlansSeeder::class);
        $this->call(DefaultTeamsSeeder::class);
        $this->call(OrdersSheetSeeder::class);
        if (app()->isLocal()) {
            // Admin::factory(1)->create();
            User::factory(30)->create();
            Order::factory(360)->create();
            // $this->call(UserTeamsSeeder::class);
        }
    }
}

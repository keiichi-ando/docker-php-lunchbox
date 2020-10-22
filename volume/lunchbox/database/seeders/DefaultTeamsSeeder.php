<?php

namespace Database\Seeders;

use App\Models\Membership;
use Illuminate\Database\Seeder;
use App\Models\Team;

class DefaultTeamsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Team::insert([
            ['user_id' => 1, 'name' => '管理者',  'personal_team' => false, 'created_at' => date('Y-m-d H:i:s')],
        ]);
        Membership::insert([
            ['user_id' => 1, 'team_id' => 1, 'role' => 'admin', 'created_at' => date('Y-m-d H:i:s')],
        ]);
    }
}

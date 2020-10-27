<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

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
            ['user_id' => 1, 'name' => '本社',  'personal_team' => false, 'created_at' => date('Y-m-d H:i:s')],
            ['user_id' => 2, 'name' => '支社',  'personal_team' => false, 'created_at' => date('Y-m-d H:i:s')],
        ]);
        User::insert([
            ['id' => 1,
                'name' => '本社 admin',
                'email' => 'admin1@exmple.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
                'current_team_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            ['id' => 2,
                'name' => '支社 admin',
                'email' => 'admin2@exmple.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
                'current_team_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ]);
    }
}

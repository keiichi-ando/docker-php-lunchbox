<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserTeamsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        // $id = 1;
        foreach ($users as $user) {
            Team::insert([
                ['user_id' => $user->id, 'name' => $user->name . '\'s team',  'personal_team' => true, 'created_at' => date('Y-m-d H:i:s')],
            ]);
        }
    }
}

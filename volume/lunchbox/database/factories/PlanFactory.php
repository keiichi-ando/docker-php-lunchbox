<?php

namespace Database\Factories;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Plan::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $names = ['極ランチ','通常ランチ'];
        // $names = ['松花堂弁当','ランチパック','極ランチ','通常ランチ'];
        return [
            'name'=> $this->faker->unique()->randomElement($names),
            'reserve_limit_h'=> $this->faker->numberBetween($min = 1, $max = 14),
            //
        ];
    }
}

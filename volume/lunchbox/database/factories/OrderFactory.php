<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $g = new \DateTime();
        foreach (range(-7, 21) as $i) {
            $g->setISODate(date('Y'), date('W'), $i);
            if (!in_array($g->format('w'), [0,6])) {
                $dates[] = $g->format('Y-m-d');
            }
        }
        $user_ids = DB::table('users')->pluck('id');
        $plan_ids = DB::table('plans')->pluck('id');

        $matrix = $user_ids->crossJoin($dates);//->crossJoin($plan_ids);
        $key_pair = $this->faker->unique()->randomElement($matrix);

        return [
            'user_id' => $key_pair[0],
            'target_date' => $key_pair[1],
            'plan_id' => $this->faker->randomElement($plan_ids),
            'close_time'=> 'a'
        ];
    }
}

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
        // $user_ids = DB::table('users')->select('id')->get();
        // $plan_ids = DB::table('plans')->select('id')->get();
        $user_ids = DB::table('users')->pluck('id');
        $plan_ids = DB::table('plans')->pluck('id');
        // 'plan_id' => $this->faker->randomElement($plan_ids)->id,

        // $user_ids = User::all()->pluck('id');
        //$plan_ids = [1,2];//Plan::all()->pluck('id');//
        // $plan_ids = DB::table('plans')->select('id')->get();
        $calendar = $this->faker->unique()->dateTimeBetween($startDate = '-7 days', $endDate = '7 days')->format('Y-m-d');
        $matrix = $user_ids->crossJoin($calendar);//->crossJoin($plan_ids);
        $key_pair = $this->faker->unique()->randomElement($matrix);
        // print_r($key_pair);
        // print_r($plan_ids);
            // 'target_date' => $this->faker->dateTimeBetween($startDate = '-7 days', $endDate = '7 days')->format('Y-m-d'),
            // 'plan_id' => $this->faker->randomElement($plan_ids)->id,

        return [
            'user_id' => $key_pair[0],
            'target_date' => $key_pair[1],
            'plan_id' => $this->faker->randomElement($plan_ids),
            'close_time'=> 'a'
        ];
    }
}

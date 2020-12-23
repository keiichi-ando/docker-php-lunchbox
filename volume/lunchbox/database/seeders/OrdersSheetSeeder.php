<?php

namespace Database\Seeders;

use App\Models\OrdersSheet;
use Illuminate\Database\Seeder;

class OrdersSheetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $g = new \DateTime();
        foreach (range(-7, 60) as $i) {
            $g->setISODate(date('Y'), date('W'), $i);
            OrdersSheet::Insert(['orderdate' => $g->format('Y-m-d'), 'ordered' => $g->format('Y-m-d') <= date('Y-m-d'), 'created_at' => date('Y-m-d H:i:s')]);
        }
    }
}

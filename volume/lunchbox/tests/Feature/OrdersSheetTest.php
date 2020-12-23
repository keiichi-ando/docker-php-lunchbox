<?php

namespace Tests\Feature;

use App\Models\OrdersSheet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrdersSheetTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testオーダーシート()
    {
        $dt = OrdersSheet::find(date('Y-m-d'));
        $this->assertTrue((bool)$dt->ordered);

        $dt = OrdersSheet::find(date('Y-m-d'), strtotime('+1 day'));
        $this->assertFalse((bool)$dt->ordered);

        $orderdates = OrdersSheet::where('orderdate', '>=', date('Y-m-d'))->orderBy('orderdate')->limit(28)->get(['orderdate']);
        $this->assertEquals($orderdates[0]->orderdate, (string)date('Y-m-d'));
    }
}

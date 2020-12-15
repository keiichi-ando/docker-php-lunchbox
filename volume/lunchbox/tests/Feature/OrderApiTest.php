<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_ランチメニュー()
    {
        $response = $this->json('GET', route('api.order.index'));

        $this->assertEquals(date('Y-m-d'), $response['calendar'][0][date('w')]['date']);
        $this->assertEquals(date('Y-m-d', strtotime('+1 week')), $response['calendar'][1][date('w')]['date']);
        $this->assertEquals(date('Y-m-d', strtotime('+2 week')), $response['calendar'][2][date('w')]['date']);
        $this->assertEquals(date('Y-m-d', strtotime('+3 week')), $response['calendar'][3][date('w')]['date']);

        $response->assertStatus(200);
    }
}

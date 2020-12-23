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
        $keys = array_keys($response['calendar']);

        $this->assertTrue($keys[0] < $keys[1]);
        $this->assertEquals(date('w'), array_search(date('Y-m-d'), $keys));
        $this->assertEquals(28, count($keys));

        $response->assertStatus(200);
    }
}

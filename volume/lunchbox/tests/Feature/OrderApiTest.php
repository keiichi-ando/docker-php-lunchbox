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
        $response = $this->json('GET', route('order.index'));

        print(json_encode($response));

        $this->assertEquals(date('Y-m-d'), $response['calendar'][0][date('w')]['date']);

        $response->assertStatus(200); //->assertJson(['calendar' => $response['calendar']]);
    }
}

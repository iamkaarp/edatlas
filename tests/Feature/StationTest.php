<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StationTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_get_all(): void
    {
        $this->seed();

        $response = $this->get('/api/v1/stations');

        $content = json_decode($response->getContent());
        $response->assertStatus(200);
        $this->assertTrue(count($content->data) == 25);
    }
}

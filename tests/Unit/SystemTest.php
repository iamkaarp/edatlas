<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\Models\System;

class SystemTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic unit test example.
     */
    public function test_system_can_be_created(): void
    {
        $params = [
            'name' => 'Sol',
            'address' => 12345,
            'x' => 0,
            'y' => 0,
            'z' => 0,
            'population' => 100000000000,
            'security' => 'high',
            'allegiance' => 'Federation',
            'government' => 'Democracy',
            'economy' => 'Industrial',
            'second_economy' => 'Refinery',
            'distance' => 0,
        ];

        $system = System::factory()->create($params);

        $this->assertModelExists($system);
        $this->assertDatabaseCount(System::class, 1);
        $this->assertEquals($system->name, $params['name']);
        $this->assertEquals($system->address, $params['address']);
        $this->assertEquals($system->x, $params['x']);
        $this->assertEquals($system->y, $params['y']);
        $this->assertEquals($system->z, $params['z']);
        $this->assertEquals($system->population, $params['population']);
        $this->assertEquals($system->security, $params['security']);
        $this->assertEquals($system->allegiance, $params['allegiance']);
        $this->assertEquals($system->government, $params['government']);
        $this->assertEquals($system->economy, $params['economy']);
        $this->assertEquals($system->second_economy, $params['second_economy']);
        $this->assertEquals($system->distance, $params['distance']);
    }

    public function test_system_can_be_deleted(): void
    {
        $system = System::factory()->create();

        $this->assertModelExists($system);
        $this->assertDatabaseCount(System::class, 1);

        $system->delete();

        $this->assertModelMissing($system);
        $this->assertDatabaseCount(System::class, 0);
    }

    public function test_system_can_be_updated(): void
    {
        $system = System::factory()->create();

        $this->assertModelExists($system);
        $this->assertDatabaseCount(System::class, 1);

        $system->name = 'Sol';
        $system->save();
        
        $this->assertModelExists($system);
        $this->assertDatabaseCount(System::class, 1);
        $this->assertEquals($system->name, 'Sol');
    }
}

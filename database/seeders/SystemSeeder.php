<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator;

use App\Models\System;
use App\Models\Faction;
use App\Models\Station;
use App\Models\Market;

class SystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = app(Generator::class);
        System::factory()->count(50)->create();
        $systems = System::all();

        $systems->each(function ($system) use ($faker) {
            $factions = Faction::factory()->count(5)->create(['system_id' => $system->id]);
            $faction = Faction::where('system_id', $system->id)->orderBy('influence', 'desc')->first();
            $system->update(['faction_id' => $faction->id]);
            $system->save();

            $hasStations = $faker->boolean(50);
            if($hasStations) {
                $stationFaction = Faction::where('system_id', $system->id)->inRandomOrder()->first();
                $numStations = $faker->numberBetween(1, 5);
                $stations = Station::factory()->hasMarket(1, function (array $attributes, Station $station) {
                    return ['id' => $station->market_id];
                })->count($numStations)->create(['system_id' => $system->id, 'faction_id' => $stationFaction->id]);
            }
        });
    }
}

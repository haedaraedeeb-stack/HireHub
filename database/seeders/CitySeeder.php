<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            ['name' => 'New York', 'country_id' => 1],
            ['name' => 'Toronto', 'country_id' => 2],
            ['name' => 'Paris', 'country_id' => 3],
            ['name' => 'Berlin', 'country_id' => 4],
            ['name' => 'Munich', 'country_id' => 4],
            ['name' => 'Madrid', 'country_id' => 5],
            ['name' => 'Rome', 'country_id' => 6],
            ['name' => 'Lisbon', 'country_id' => 7],
            ['name' => 'Stockholm', 'country_id' => 8],
            ['name' => 'Oslo', 'country_id' => 9],
            ['name' => 'Copenhagen', 'country_id' => 10],
        ];
        foreach($cities as $city) {
            City::create($city);
        }
    }
}

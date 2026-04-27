<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            ['name' => 'United States'],
            ['name' => 'Canada'],
            ['name' => 'France'],
            ['name' => 'Germany'],
            ['name' => 'Spain'],
            ['name' => 'Italy'],
            ['name' => 'Portogal'],
            ['name' => 'India'],
            ['name' => 'Japan'],
            ['name' => 'China']
        ];
        foreach($countries as $country) {
            Country::create($country);
        }
    }
}

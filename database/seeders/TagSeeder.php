<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
        ['name' => 'Web Development'],
        ['name' => 'Mobile App'],
        ['name' => 'Logo Design'],
        ['name' => 'E-commerce'],
        ['name' => 'SaaS'],
        ['name' => 'Bug Fixing'],
        ['name' => 'Deployment'],
        ['name' => 'Cyber Security'],
        ['name' => 'Data Scraping'],
        ['name' => 'Machine Learning'],
        ];

    foreach ($tags as $tag) {
        Tag::create($tag);
    }
    }
}

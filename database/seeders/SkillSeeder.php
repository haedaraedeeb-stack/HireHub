<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = [
        ['name' => 'PHP'],
        ['name' => 'Laravel'],
        ['name' => 'Node.js'],
        ['name' => 'Python'],
        ['name' => 'Django'],
        ['name' => 'MySQL'],
        ['name' => 'PostgreSQL'],
        ['name' => 'API Development'],

        ['name' => 'HTML5'],
        ['name' => 'CSS3'],
        ['name' => 'JavaScript'],
        ['name' => 'Vue.js'],
        ['name' => 'React'],
        ['name' => 'Tailwind CSS'],
        ['name' => 'Bootstrap'],

        ['name' => 'Flutter'],
        ['name' => 'React Native'],
        ['name' => 'Swift'],
        ['name' => 'Kotlin'],

        ['name' => 'UI/UX Design'],
        ['name' => 'Adobe Photoshop'],
        ['name' => 'Figma'],
        ['name' => 'Adobe Illustrator'],
        ['name' => 'Minimalist Branding'],

        ['name' => 'SEO'],
        ['name' => 'Technical Writing'],
        ['name' => 'Project Management'],
        ['name' => 'AWS / Cloud Computing'],
        ['name' => 'Docker'],
    ];

    foreach ($skills as $skill) {
        Skill::create($skill);
        }
    }
}

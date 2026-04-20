<?php

namespace Database\Seeders;

use App\Models\Freelancer;
use App\Models\User;
use App\Models\Skill; 
use App\Enums\FreelancerStatus;
use Illuminate\Database\Seeder;

class FreelancerSeeder extends Seeder
{
    public function run(): void
    {
        $freelancers = User::where('role', 'freelancer')->get();

        $allSkills = Skill::all();

        $bios = [
            "Full-stack developer with 5 years of experience in Laravel and Vue.js.",
            "Graphic designer specialized in minimalist branding and logo design.",
            "Mobile app developer (Flutter & React Native).",
            "Expert UI/UX designer focused on user-centric web platforms.",
            "Content writer and SEO specialist for tech blogs.",
            "Backend engineer specialized in PHP and MySQL core systems.",
            "Data analyst with experience in Python and PowerBI.",
            "DevOps engineer specialized in AWS and Docker.",
            "Digital marketing expert and social media manager.",
            "Technical translator (English/Arabic) with computer science background."
        ];

        foreach ($freelancers as $index => $user) {
            $bioIndex = $index % count($bios);

            $freelancer = Freelancer::create([
                'user_id' => $user->id,
                'bio' => $bios[$bioIndex],
                'price_per_hour' => rand(20, 150),
                'phone_number' => '0933' . rand(100000, 999999),
                'status' => FreelancerStatus::AVAILABLE,
                'portfolio_links' => [
                    'https://github.com/user' . $user->id,
                    'https://behance.net/user' . $user->id
                ],
                'skills_summary' => ['PHP', 'Laravel', 'Tailwind']
            ]);

            if ($allSkills->count() > 0) {
                $randomSkills = $allSkills->random(rand(2, 4));

                foreach ($randomSkills as $skill) {
                    $freelancer->skills()->attach($skill->id, [
                        'experience_years' => rand(1, 10),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}

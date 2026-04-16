<?php

namespace Database\Seeders;

use App\Models\Freelancer;
use App\Models\User;
use App\Enums\FreelancerStatus;
use Illuminate\Database\Seeder;

class FreelancerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $freelancers = User::where('role', 'freelancer')->get();

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

        foreach ($freelancers as $index => $freelancer) {
            $bioIndex = $index % count($bios);

            Freelancer::create([
                'user_id' => $freelancer->id,
                'bio' => $bios[$bioIndex],
                'price_per_hour' => rand(20, 150),
                'phone_number' => '0933' . rand(100000, 999999),
                'status' => FreelancerStatus::AVAILABLE,
                'portfolio_links' => [
                    'https://github.com/user' . $freelancer->id,
                    'https://behance.net/user' . $freelancer->id
                ],
                'skills_summary' => ['PHP', 'Laravel', 'Tailwind']
            ]);
        }
    }
}

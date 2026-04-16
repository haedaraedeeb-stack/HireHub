<?php

namespace Database\Seeders;

use App\Models\Freelancer;
use App\Models\Offer;
use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $freelancers = Freelancer::all();
        $projects = Project::where('status', 'open')->get();
        $sampleLetters = [
        "I am very interested in your project. I have extensive experience in this field and can deliver high-quality results within your timeframe.",
        "Hello! I've worked on similar projects before. Check my profile for my portfolio. I would love to discuss the details with you.",
        "I can handle this task efficiently. My expertise matches your requirements perfectly. Looking forward to working together.",
        "Professional service guaranteed. I have 5+ years of experience and I am available to start immediately.",
        "I have read your description carefully. I can provide a modern and scalable solution for your needs."
        ];
        foreach ($projects as $project) {
            $numberOfOffers = rand(2, 5);
            $randomFreelancers = $freelancers->random($numberOfOffers);
            foreach ($randomFreelancers as $freelancer) {
            Offer::create([
                'freelancer_id' => $freelancer->id,
                'project_id' => $project->id,
                'price' => $project->budget_type === 'fixed'
                    ? $project->getRawOriginal('budget') - rand(10, 50)
                    : $project->getRawOriginal('budget') + rand(5, 15),
                'letter' => $sampleLetters[array_rand($sampleLetters)],
                'status' => 'pending',
                'delivery_days' => rand(3, 20),
            ]);
        }
        }


    }
}

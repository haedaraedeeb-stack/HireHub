<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
{
    $clientIds = \App\Models\User::where('role', 'client')->pluck('id')->toArray();

    $projects = [
        [
            'title' => 'E-commerce Mobile App',
            'description' => 'Need a professional Flutter developer to build a full e-commerce app with payment integration.',
            'budget_type' => 'fixed',
            'budget' => 2500.00,
            'deadline' => now()->addMonths(2),
            'status' => 'open',
        ],
        [
            'title' => 'Laravel Backend for SaaS',
            'description' => 'Looking for a backend expert to build a multi-tenant API using Laravel 11.',
            'budget_type' => 'hourly',
            'budget' => 40.00,
            'deadline' => now()->addMonths(1),
            'status' => 'open',
        ],
        [
            'title' => 'Minimalist Logo Design',
            'description' => 'Design a clean and modern logo for a new tech startup. No text, just symbols.',
            'budget_type' => 'fixed',
            'budget' => 300.00,
            'deadline' => now()->addWeeks(1),
            'status' => 'open',
        ],
        [
            'title' => 'Python Web Scraper',
            'description' => 'Develop a script to scrape real estate data from multiple sources daily.',
            'budget_type' => 'fixed',
            'budget' => 500.00,
            'deadline' => now()->addWeeks(2),
            'status' => 'closed',
        ],
        [
            'title' => 'UI/UX Redesign for Dashboard',
            'description' => 'Redesign our current admin dashboard to be more user-friendly and modern.',
            'budget_type' => 'hourly',
            'budget' => 35.00,
            'deadline' => now()->addDays(10),
            'status' => 'in_progress',
        ],
        [
            'title' => 'WordPress Blog Setup',
            'description' => 'Set up a WordPress blog with a premium theme and SEO optimization.',
            'budget_type' => 'fixed',
            'budget' => 150.00,
            'deadline' => now()->addDays(5),
            'status' => 'open',
        ],
        [
            'title' => 'React Landing Page',
            'description' => 'Build a high-converting landing page using React and Tailwind CSS.',
            'budget_type' => 'fixed',
            'budget' => 800.00,
            'deadline' => now()->addWeeks(3),
            'status' => 'open',
        ],
        [
            'title' => 'API Integration Specialist',
            'description' => 'Connect our CRM with Stripe and Mailchimp APIs.',
            'budget_type' => 'hourly',
            'budget' => 50.00,
            'deadline' => now()->addMonth(),
            'status' => 'open',
        ],
        [
            'title' => 'Content Writing for Tech Blog',
            'description' => 'Write 10 articles about Cyber Security and Cloud Computing.',
            'budget_type' => 'fixed',
            'budget' => 400.00,
            'deadline' => now()->addMonths(1),
            'status' => 'open',
        ],
        [
            'title' => 'Social Media App UI',
            'description' => 'Create high-fidelity wireframes for a new social media platform.',
            'budget_type' => 'fixed',
            'budget' => 1200.00,
            'deadline' => now()->addWeeks(4),
            'status' => 'open',
        ],
    ];

    foreach ($projects as $index => $projectData) {
        $projectData['user_id'] = $clientIds[array_rand($clientIds)];
        Project::create($projectData);
    }
}
}

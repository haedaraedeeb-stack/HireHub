<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
{
    $clientIds = User::where('role', 'client')->pluck('id')->toArray();
    $tagIds = Tag::pluck('id');
    $projects = [
        ['title' => 'E-commerce Mobile App', 'description' => 'Need a professional Flutter developer to build a full e-commerce app with payment integration.', 'budget_type' => 'fixed', 'budget' => 2500.00, 'deadline' => now()->addMonths(2), 'status' => 'open'],
        ['title' => 'Laravel Backend for SaaS', 'description' => 'Looking for a backend expert to build a multi-tenant API using Laravel 11.', 'budget_type' => 'hourly', 'budget' => 40.00, 'deadline' => now()->addMonths(1), 'status' => 'open'],
        ['title' => 'Vue.js Single Page Application', 'description' => 'Convert our current multi-page website into a fast SPA using Vue3 and Vuex.', 'budget_type' => 'fixed', 'budget' => 1200.00, 'deadline' => now()->addWeeks(3), 'status' => 'closed'],
        ['title' => 'WordPress Blog Setup', 'description' => 'Set up a WordPress blog with a premium theme and SEO optimization.', 'budget_type' => 'fixed', 'budget' => 150.00, 'deadline' => now()->addDays(5), 'status' => 'closed'],
        ['title' => 'React Landing Page', 'description' => 'Build a high-converting landing page using React and Tailwind CSS.', 'budget_type' => 'fixed', 'budget' => 800.00, 'deadline' => now()->addWeeks(3), 'status' => 'open'],
        ['title' => 'API Integration Specialist', 'description' => 'Connect our CRM with Stripe and Mailchimp APIs.', 'budget_type' => 'hourly', 'budget' => 50.00, 'deadline' => now()->addMonth(), 'status' => 'open'],
        ['title' => 'Real Estate Portal in PHP', 'description' => 'Develop a custom property management portal using Core PHP and MySQL.', 'budget_type' => 'fixed', 'budget' => 3000.00, 'deadline' => now()->addMonths(3), 'status' => 'in_progress'],
        ['title' => 'Fix Bugs in Node.js App', 'description' => 'We have memory leak issues in our Node backend. Need an expert to debug.', 'budget_type' => 'hourly', 'budget' => 60.00, 'deadline' => now()->addDays(3), 'status' => 'open'],
        ['title' => 'Shopify Store Customization', 'description' => 'Customize the checkout process of our existing Shopify liquid theme.', 'budget_type' => 'fixed', 'budget' => 450.00, 'deadline' => now()->addWeeks(2), 'status' => 'closed'],
        ['title' => 'Web3 DApp Interface', 'description' => 'Build the frontend for our smart contract using Next.js and Ethers.js.', 'budget_type' => 'fixed', 'budget' => 4000.00, 'deadline' => now()->addMonths(2), 'status' => 'open'],

        // --- Mobile Development ---
        ['title' => 'Social Media App UI', 'description' => 'Create high-fidelity wireframes for a new social media platform.', 'budget_type' => 'fixed', 'budget' => 1200.00, 'deadline' => now()->addWeeks(4), 'status' => 'open'],
        ['title' => 'Food Delivery App (React Native)', 'description' => 'Need both user and driver apps for a local food delivery service.', 'budget_type' => 'fixed', 'budget' => 3500.00, 'deadline' => now()->addMonths(3), 'status' => 'open'],
        ['title' => 'Fitness Tracker iOS App', 'description' => 'Swift developer needed to build an app that tracks running routes via GPS.', 'budget_type' => 'hourly', 'budget' => 45.00, 'deadline' => now()->addMonths(2), 'status' => 'closed'],
        ['title' => 'Android App Bug Fixing', 'description' => 'App crashes on Android 13. Need a Kotlin expert to fix it ASAP.', 'budget_type' => 'fixed', 'budget' => 200.00, 'deadline' => now()->addDays(2), 'status' => 'open'],
        ['title' => 'Kotlin Audio Player', 'description' => 'Build a background audio streaming app using Kotlin.', 'budget_type' => 'fixed', 'budget' => 900.00, 'deadline' => now()->addWeeks(3), 'status' => 'in_progress'],
        ['title' => 'Update Flutter Packages', 'description' => 'Migrate an old Flutter project to the latest version with null safety.', 'budget_type' => 'fixed', 'budget' => 300.00, 'deadline' => now()->addWeeks(1), 'status' => 'closed'],
        ['title' => 'Mobile Game Developer (Unity)', 'description' => 'Create a simple 2D puzzle game for iOS and Android.', 'budget_type' => 'fixed', 'budget' => 1500.00, 'deadline' => now()->addMonths(1), 'status' => 'open'],
        ['title' => 'Push Notifications Integration', 'description' => 'Implement Firebase Cloud Messaging in our existing React Native app.', 'budget_type' => 'fixed', 'budget' => 150.00, 'deadline' => now()->addDays(4), 'status' => 'closed'],

        // --- Design & UI/UX ---
        ['title' => 'Minimalist Logo Design', 'description' => 'Design a clean and modern logo for a new tech startup. No text, just symbols.', 'budget_type' => 'fixed', 'budget' => 300.00, 'deadline' => now()->addWeeks(1), 'status' => 'open'],
        ['title' => 'UI/UX Redesign for Dashboard', 'description' => 'Redesign our current admin dashboard to be more user-friendly and modern.', 'budget_type' => 'hourly', 'budget' => 35.00, 'deadline' => now()->addDays(10), 'status' => 'closed'],
        ['title' => 'Corporate Branding Package', 'description' => 'Need business cards, letterheads, and email signatures designed.', 'budget_type' => 'fixed', 'budget' => 250.00, 'deadline' => now()->addWeeks(2), 'status' => 'open'],
        ['title' => '3D Product Rendering', 'description' => 'Create realistic 3D renders for our new line of ergonomic chairs.', 'budget_type' => 'fixed', 'budget' => 600.00, 'deadline' => now()->addWeeks(3), 'status' => 'open'],
        ['title' => 'Podcast Cover Art', 'description' => 'Illustrate an engaging cover art for a true crime podcast.', 'budget_type' => 'fixed', 'budget' => 100.00, 'deadline' => now()->addDays(5), 'status' => 'closed'],
        ['title' => 'Figma Prototyping', 'description' => 'Turn our sketches into a fully clickable prototype in Figma.', 'budget_type' => 'hourly', 'budget' => 30.00, 'deadline' => now()->addWeeks(1), 'status' => 'in_progress'],
        ['title' => 'Infographic Design', 'description' => 'Summarize a 10-page report into a visually appealing infographic.', 'budget_type' => 'fixed', 'budget' => 180.00, 'deadline' => now()->addDays(7), 'status' => 'open'],
        ['title' => 'YouTube Thumbnail Creator', 'description' => 'Looking for someone to design 5 catchy thumbnails for a gaming channel.', 'budget_type' => 'fixed', 'budget' => 75.00, 'deadline' => now()->addDays(3), 'status' => 'closed'],

        // --- Data, Scripts & AI ---
        ['title' => 'Python Web Scraper', 'description' => 'Develop a script to scrape real estate data from multiple sources daily.', 'budget_type' => 'fixed', 'budget' => 500.00, 'deadline' => now()->addWeeks(2), 'status' => 'closed'],
        ['title' => 'Machine Learning Prediction Model', 'description' => 'Train a model to predict customer churn based on historical data.', 'budget_type' => 'fixed', 'budget' => 2000.00, 'deadline' => now()->addMonths(1), 'status' => 'open'],
        ['title' => 'Automate Excel Reports', 'description' => 'Write a VBA or Python script to automate our weekly financial Excel sheets.', 'budget_type' => 'fixed', 'budget' => 250.00, 'deadline' => now()->addDays(5), 'status' => 'open'],
        ['title' => 'Database Migration (MySQL to Postgres)', 'description' => 'Safely migrate our production database with zero downtime.', 'budget_type' => 'hourly', 'budget' => 80.00, 'deadline' => now()->addWeeks(2), 'status' => 'closed'],
        ['title' => 'Power BI Dashboard Dashboard', 'description' => 'Visualize sales data from our SQL server using PowerBI.', 'budget_type' => 'fixed', 'budget' => 600.00, 'deadline' => now()->addWeeks(3), 'status' => 'open'],
        ['title' => 'Chatbot Development', 'description' => 'Build a customer support chatbot using OpenAI API and integrate it with WhatsApp.', 'budget_type' => 'fixed', 'budget' => 1500.00, 'deadline' => now()->addMonths(1), 'status' => 'in_progress'],
        ['title' => 'Data Cleaning task', 'description' => 'Clean and format a messy CSV file with 50,000 rows of contact info.', 'budget_type' => 'fixed', 'budget' => 100.00, 'deadline' => now()->addDays(2), 'status' => 'closed'],

        // --- Writing, Translation & Marketing ---
        ['title' => 'Content Writing for Tech Blog', 'description' => 'Write 10 articles about Cyber Security and Cloud Computing.', 'budget_type' => 'fixed', 'budget' => 400.00, 'deadline' => now()->addMonths(1), 'status' => 'open'],
        ['title' => 'Translate App from English to Arabic', 'description' => 'Localize our mobile app strings (JSON file).', 'budget_type' => 'fixed', 'budget' => 150.00, 'deadline' => now()->addDays(4), 'status' => 'closed'],
        ['title' => 'SEO Audit for E-commerce', 'description' => 'Perform a full technical SEO audit and provide a detailed action plan.', 'budget_type' => 'hourly', 'budget' => 40.00, 'deadline' => now()->addWeeks(1), 'status' => 'open'],
        ['title' => 'Social Media Manager', 'description' => 'Manage our Instagram and LinkedIn accounts for 1 month.', 'budget_type' => 'fixed', 'budget' => 500.00, 'deadline' => now()->addMonths(1), 'status' => 'in_progress'],
        ['title' => 'Write a Pitch Deck', 'description' => 'Create a compelling pitch deck presentation for investors.', 'budget_type' => 'fixed', 'budget' => 800.00, 'deadline' => now()->addWeeks(2), 'status' => 'open'],
        ['title' => 'Google Ads Campaign Setup', 'description' => 'Set up and optimize a search campaign for a local dental clinic.', 'budget_type' => 'fixed', 'budget' => 300.00, 'deadline' => now()->addDays(7), 'status' => 'closed'],

        // --- System Admin & DevOps ---
        ['title' => 'AWS Server Setup', 'description' => 'Deploy a Laravel application on AWS EC2 with RDS and S3.', 'budget_type' => 'fixed', 'budget' => 400.00, 'deadline' => now()->addDays(5), 'status' => 'open'],
        ['title' => 'Dockerize Existing App', 'description' => 'Create Docker and docker-compose files for a legacy PHP application.', 'budget_type' => 'fixed', 'budget' => 200.00, 'deadline' => now()->addDays(3), 'status' => 'closed'],
        ['title' => 'CI/CD Pipeline with GitHub Actions', 'description' => 'Set up automated testing and deployment to DigitalOcean.', 'budget_type' => 'hourly', 'budget' => 55.00, 'deadline' => now()->addWeeks(1), 'status' => 'open'],
        ['title' => 'Linux Server Hardening', 'description' => 'Secure our Ubuntu server, set up firewalls and fail2ban.', 'budget_type' => 'fixed', 'budget' => 250.00, 'deadline' => now()->addDays(4), 'status' => 'open'],

        // --- Others ---
        ['title' => 'Virtual Assistant (Data Entry)', 'description' => 'Need someone for 2 hours daily to input invoices into our system.', 'budget_type' => 'hourly', 'budget' => 15.00, 'deadline' => now()->addMonths(1), 'status' => 'open'],
        ['title' => 'Video Editing for Vlogs', 'description' => 'Edit raw footage into engaging 10-minute travel vlogs.', 'budget_type' => 'fixed', 'budget' => 200.00, 'deadline' => now()->addWeeks(1), 'status' => 'closed'],
        ['title' => 'Legal Contract Drafting', 'description' => 'Draft an NDA and terms of service for a software product.', 'budget_type' => 'fixed', 'budget' => 350.00, 'deadline' => now()->addDays(7), 'status' => 'open'],
        ['title' => 'Online Math Tutor', 'description' => 'Looking for a tutor for university-level calculus (OpenGL context).', 'budget_type' => 'hourly', 'budget' => 25.00, 'deadline' => now()->addWeeks(2), 'status' => 'open'],
        ['title' => 'Voiceover for Commercial', 'description' => 'Professional male voiceover in Arabic for a 30-second ad.', 'budget_type' => 'fixed', 'budget' => 100.00, 'deadline' => now()->addDays(2), 'status' => 'closed'],
        ['title' => 'Customer Support Representative', 'description' => 'Answer support tickets on Zendesk for our tech startup.', 'budget_type' => 'hourly', 'budget' => 18.00, 'deadline' => now()->addMonths(3), 'status' => 'open'],
        ['title' => 'Resume Design & Review', 'description' => 'Review and redesign my CV to target senior Laravel developer roles.', 'budget_type' => 'fixed', 'budget' => 50.00, 'deadline' => now()->addDays(2), 'status' => 'closed'],
];

    foreach ($projects as $index => $projectData) {
        $projectData['user_id'] = $clientIds[array_rand($clientIds)];
        $project = Project::create($projectData);
        $randomTags = $tagIds->random(rand(2, 4))->toArray();
        $project->tags()->sync($randomTags);
    }
}
}

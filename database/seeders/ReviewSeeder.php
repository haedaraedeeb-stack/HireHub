<?php

namespace Database\Seeders;

use App\Models\Offer;
use App\Models\Project;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = Project::where('status', 'completed')->get();
        $freelancers = User::where('role', 'freelancer')->get();
        $clients = User::where('role', 'client')->get();

        $comments = [
        "Excellent work! Very professional and delivered on time.",
        "Great communication and high-quality results. Highly recommended.",
        "Good experience overall, though we had a minor delay in the deadline.",
        "Very creative approach to the problem. Will definitely hire again!",
        "Perfect execution of the requirements. Thank you!"
    ];

    foreach ($projects as $project) {
        $freelancerId = $project->accepted_offer_id
            ? Offer::find($project->accepted_offer_id)->freelancer_id
            : User::where('role', 'freelancer')->first()->id;

        Review::create([
            'project_id'    => $project->id,
            'client_id'     => $project->user_id,
            'freelancer_id' => $freelancerId,
            'rating'        => rand(0, 5),
            'comment'       => $comments[array_rand($comments)],
            'type'          => 'project',         
            ]);
        }
    }
}

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
        $projects = Project::whereIn('status', ['closed', 'in_progress'])->get();

        $comments = [
            "Excellent work! Very professional and delivered on time.",
            "Great communication and high-quality results. Highly recommended.",
            "Good experience overall, though we had a minor delay in the deadline.",
            "Very creative approach to the problem. Will definitely hire again!",
            "Perfect execution of the requirements. Thank you!"
        ];

        foreach ($projects as $project) {
            $acceptedOffer = Offer::where('project_id', $project->id)
                                ->where('status', 'accepted')
                                ?? Offer::where('project_id', $project->id)->first();

            if ($acceptedOffer) {
                Review::create([
                    'project_id'    => $project->id,
                    'client_id'     => $project->user_id,
                    'freelancer_id' => $acceptedOffer->freelancer_id,
                    'rating'        => rand(3, 5), 
                    'comment'       => $comments[array_rand($comments)],
                    'type'          => 'project',
                ]);
            }
        }
    }
}

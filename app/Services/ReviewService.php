<?php
namespace App\Services;

use App\Models\Project;
use App\Models\Review;

class ReviewService
{
    public function reviewProject(Project $project, array $data)
    {
        if ($project->user_id !== auth()->id()) {
            throw new \Exception('This project is not yours.', 403);
        }

        if (!in_array($project->status, ['in_progress', 'closed'])) {
            throw new \Exception('The project is not finished yet.', 403);
        }

        return Review::create([
            'project_id' => $project->id,
            'comment'    => $data['comment'] ?? null,
            'rating'     => $data['rating'],
            'type'       => 'project',
            'client_id'  => auth()->id(),
        ]);
    }

    public function reviewFreelancer(Project $project, array $data)
    {
        if ($project->user_id !== auth()->id()) {
            throw new \Exception('This project is not yours.', 403);
        }

        if (!in_array($project->status, ['in_progress', 'closed'])) {
            throw new \Exception('The project is not finished yet.', 403);
        }

        $freelancerId = $project->acceptedOffer->freelancer->user_id;

        $review = Review::create([
            'freelancer_id' => $freelancerId,
            'project_id'    => $project->id,
            'comment'       => $data['comment'] ?? null,
            'rating'        => $data['rating'],
            'type'          => 'freelancer',
            'client_id'     => auth()->id(),
        ]);


        return $review;
    }
}

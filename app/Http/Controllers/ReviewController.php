<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewFreelancer;
use App\Http\Requests\StoreReviewProject;
use App\Http\Services\ReviewService;
use App\Models\Project;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct(private ReviewService $reviewService) {}

    public function reviewProject(StoreReviewProject $request, Project $project)
    {
        $data = $request->validated();
        try{
        $review = $this->reviewService->reviewProject($project,$data);
        return $this->success($review, 'Review added successfully.', 201);
        }catch (\Exception $e) {
        return $this->failed($e->getMessage(), $e->getCode() ?: 400);
        }
    }

    public function reviewFreelancer(StoreReviewFreelancer $request, Project $project)
    {
        $data = $request->validated();
        try{
        $review = $this->reviewService->reviewFreelancer(
            $project,$data);
        return $this->success($review, 'Freelancer reviewed successfully.', 201);
        } catch (\Exception $e) {
        return $this->failed($e->getMessage(), $e->getCode() ?: 400);
        }
    }
}





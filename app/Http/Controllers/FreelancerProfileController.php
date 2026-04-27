<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFreelancerRequest;
use App\Http\Requests\UpdateFreelancerRequest;
use App\Http\Resources\FreelancerResource;
use App\Services\FreelancerService;
use App\Models\Freelancer;
use Illuminate\Http\Request;

class FreelancerProfileController extends Controller
{
    protected $freelancerservice;

    public function __construct(FreelancerService $freelancerservice)
    {
        $this->freelancerservice = $freelancerservice;
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFreelancerRequest $request)
    {
        $data = $request->validated();
        $freelancer = $this->freelancerservice->createProfile(auth()->user(), $data);
        return $this->success(
            new FreelancerResource($freelancer),
            'Profile created successfully. Please wait for verification.',
            201
        );
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFreelancerRequest $request)
    {
        $data = $request->validated();

        $freelancer = Freelancer::withoutGlobalScopes()
            ->where('user_id', auth()->id())
            ->first();

        if (!$freelancer) {
            return $this->failed('Sorry, there is no profile for you.', 404);
        }

        $updated = $this->freelancerservice->updateProfile($freelancer, $data);

        return $this->success(
            new FreelancerResource($updated),
            'Profile updated successfully.',
            200
        );
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        $freelancer = auth()->user()->freelancer;
        if (!$freelancer) {
            return $this->failed('No profile found to delete.', 404);
        }
        $freelancer->delete();
        return $this->success('Profile deleted successfully.', 200);
    }
}

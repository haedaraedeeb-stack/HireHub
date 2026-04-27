<?php

namespace App\Http\Controllers;

use App\Http\Requests\FreelancerFilterRequest;
// use App\Http\Requests\StoreFreelancerRequest;
use App\Http\Resources\FreelancerResource;
use App\Services\FreelancerService;
use App\Models\Freelancer;
// use Illuminate\Http\Request;

class FreelancerController extends Controller
{
    protected $freelancerservice;

    public function __construct(FreelancerService $freelancerservice)
    {
        $this->freelancerservice = $freelancerservice;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(FreelancerFilterRequest $request)
    {
        $data = $request->validated();
        $freelancers = $this->freelancerservice->getAvailableFreelancers($data);
        return $this->success (FreelancerResource::collection($freelancers),
        'this is the list of active and verified freelancers .', 200 );
    }
    /**
     * Display the specified resource.
     */
    public function show(Freelancer $freelancer)
    {
        $details = $this->freelancerservice->getFreelancerDetailes($freelancer);
        return $this->success (new FreelancerResource($details),
        'this is the freelancer detailes .', 200 );}
}

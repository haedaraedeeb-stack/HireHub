<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Services\ProjectService;
use App\Models\Project;

class ProjectController extends Controller
{
    protected $projectservice;

    public function __construct(ProjectService $projectservice)
    {
        $this->projectservice = $projectservice;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = $this->projectservice->listOfOpenProjects();
        return ProjectResource::collection($projects)->
        additional(['message' =>'Projects retrived successfuly .']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $data = $request->validated();
        $files = $request->file('files');
        $project = $this->projectservice->create($data, $files);
        if ($project) {
            return $this->success(new ProjectResource($project),
            "Project create completed .", 201);
        }
        else {
            return $this->failed('Something went wrong .');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $projectDetailes = $this->projectservice->getProjectDetails($project);
        if ($project) {
            return $this->success(new ProjectResource($projectDetailes),
            "Project Details .", 200);
        }
        else {
            return $this->failed('User Not Found .');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $data = $request->validated();
        $files = $request->file('files');
        $project = $this->projectservice->edit($project, $data, $files);
        if ($project) {
            return $this->success(new ProjectResource($project),
            "Project updated completed .", 201);
        }
        else {
            return $this->failed('Something went wrong .');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        if (auth()->user()->role === 'client'){
        $this->projectservice->delete($project);
        return $this->success('project is deleted with attachments', 200);
        }
    }
}

<?php
namespace App\Services;
use App\Models\Project;
use App\Models\Tag;
use Illuminate\Support\Facades\Storage;

class ProjectService
{
    public function listOfOpenProjects() {
            return Project::with([
                'user' => function($query) {
                    $query->withAvg('reviewsReceived', 'rating');
                }
                ,'tags'
                ])
                ->withCount('offers')->paginate(15);
    }

    public function create($data, $files = null) {
        $data['user_id'] = auth()->id();
        $tagNames = isset($data['tags']) ? $data['tags'] : [];
        unset($data['tags']);
        $project = Project::create(collect($data)->except('tags')->toArray());
        if (!empty($tagNames)) {
        $tagIds = Tag::whereIn('name', $tagNames)->pluck('id')->toArray();
        $project->tags()->sync($tagIds);}
        if($files){
            foreach ($files as $file) {
                $path = $file->store('projects/attachments', 'public');
                $project->attachments()->create(['file_path' => $path]);
            }
        }
        return $project;
    }

    public function getProjectDetails(Project $project) {
        return$project->load([
            'user' => function($query) {
            $query->withAvg('reviewsReceived', 'rating');
        },
            'offers.attachments',
            'reviews',
            'attachments',
            'tags',
            'reviews.user',
        ]);
    }

    public function edit(Project $project, $data, $files  = null) {
        $tagNames = isset($data['tags']) ? $data['tags'] : [];
        unset($data['tags']);
        $project->update(collect($data)->except('tags')->toArray());
        if (!empty($tagNames)) {
        $tagIds = Tag::whereIn('name', $tagNames)->pluck('id')->toArray();
        $project->tags()->sync($tagIds);}
        if($files){
            foreach ($files as $file) {
                $path = $file->store('projects/attachments','public');
                $project->attachments()->create(['file_path' => $path]);
            }
        }
        return $project->load(['tags', 'attachments']);
    }

    public function delete(Project $project) {
        foreach ($project->attachments as $attachment) {
            Storage::disk('public')->delete($attachment->file_path);
            $attachment->delete();
        }
        return $project->delete();
    }

}

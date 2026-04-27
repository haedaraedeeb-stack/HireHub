<?php
namespace App\Services;
use App\Jobs\SendProjectPublishedJob;
use App\Models\Project;
use App\Models\Tag;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ProjectService
{
    public function listOfOpenProjects() {
    $ids = Cache::tags(['open_projects'])->remember('open_projects', 300, function () {
        return Project::withCount('offers')
            ->latest()
            ->pluck('id')
            ->toArray();
    });

    return Project::with([
        'user' => function($query) {
            $query->withAvg('reviewsReceived', 'rating');
        },
        'tags'
    ])
    ->withCount('offers')
    ->whereIn('id', $ids)
    ->paginate(15);
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
        Cache::tags(['open_projects'])->flush();
        SendProjectPublishedJob::dispatch($project);
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
        Cache::tags(['open_projects'])->flush();
        return $project->load(['tags', 'attachments']);
    }

    public function delete(Project $project) {
        foreach ($project->attachments as $attachment) {
            Storage::disk('public')->delete($attachment->file_path);
            $attachment->delete();
        }
        Cache::tags(['open_projects'])->flush();
        return $project->delete();
    }

}

<?php
namespace App\Jobs;

use App\Models\Project;
use App\Notifications\ProjectPublishedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendProjectPublishedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 60;

    public function __construct(public Project $project) {}

    public function handle(): void
    {
        $this->project->user->notify(
            new ProjectPublishedNotification($this->project)
        );
    }
}

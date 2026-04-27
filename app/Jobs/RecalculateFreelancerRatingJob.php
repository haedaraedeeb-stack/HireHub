<?php

namespace App\Jobs;

use App\Models\Freelancer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class RecalculateFreelancerRatingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Freelancer $freelancer) {}

    public function handle(): void
    {
        // $review->freelancer->load('freelancer');
        $lock = Cache::lock('rating_freelancer_' . $this->freelancer->id, 10);

        if ($lock->get()) {
            try {
                $average = $this->freelancer->reviews()->avg('rating');
                $this->freelancer->update([
                    'average_rating' => round($average, 2),
                ]);
                Cache::tags(['available_freelancers'])->flush();
            } finally {
                $lock->release();
            }
        }
    }
}

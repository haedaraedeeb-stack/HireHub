<?php
namespace App\Jobs;

use App\Models\Offer;
use App\Notifications\OfferAcceptedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendOfferAcceptedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 60;

    public function __construct(public Offer $offer) {}

    public function handle(): void
    {
        $this->offer->load(['project' => function($query)
        {
            $query->withoutGlobalScopes();
        }, 'freelancer.user']);
        $this->offer->freelancer->user->notify(
            new OfferAcceptedNotification($this->offer, $this->offer->project->title)
        );
    }
}

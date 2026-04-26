<?php
namespace App\Http\Services;

use App\Models\Offer;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class OfferService
{
    public function proposeOffer ($data, $userId)
    {
        $user = User::with('freelancer')->findOrFail($userId);
        if (!$user->freelancer) {
        throw new \Exception('you should createing a profile first .');
        }
        $project = Project::findOrFail($data['project_id']);
        $exists = Offer::where('project_id' , $data['project_id'])
        ->where('freelancer_id', $user->freelancer->id)->exists();
        if ($exists) {
            throw new \Exception ('you already make an offer .');
        }
        if ($project->user_id === $userId) {
        throw new \Exception('You can not make an offer on your personal project .');
        }
        return DB::transaction(function () use ($data, $user) {
        $offer = Offer::create([
            'freelancer_id' => $user->freelancer->id,
            'project_id'    => $data['project_id'],
            'price'         => $data['price'],
            'letter'        => $data['letter'],
            'delivery_days' => $data['delivery_days'],
            'status'        => 'pending',
        ]);
        if (isset($data['attachments'])) {
            foreach ($data['attachments'] as $file) {
                $path = $file->store('offers/attachments', 'public');
                $offer->attachments()->create([
                    'file_path' => $path,
                    'file_name' => $file->getClientOriginalName(),
                    'file_type' => $file->getClientMimeType(),
                ]);
            }
        }

        return $offer;
        });
    }

    public function getOfferDetails(Offer $offer)
    {
    $offer->load(['project' => function($query) {
        $query->withoutGlobalScope('opened');
    }, 'project.user', 'attachments']);

    return $offer;
    }

    public function updateOfferStatus(Offer $offer, string $newStatus)
{
    return DB::transaction(function () use ($offer, $newStatus) {
        $offer->update(['status' => $newStatus]);
        if ($newStatus === 'accepted') {
            $offer->project()->withoutGlobalScope('opened')->update
            (['status' => 'in_progress',
            'accepted_offer_id' => $offer->id ]);
            Offer::where('project_id', $offer->project_id)
                ->where('id', '!=', $offer->id)
                ->where('status', 'pending')
                ->update(['status' => 'rejected']);
        }

        return $offer;
    });
}
}

<?php

namespace App\Http\Resources;

use App\Http\Resources\ReviewResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FreelancerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'full_name' => $this->full_name,
            'bio' => $this->bio,
            'is_verified' => $this->user?->is_verified,
            'location' => [
                'country' => $this->user?->country?->name ?? 'N/A',
                'city' => $this->user?->city?->name ?? 'N/A',
            ],
            'image' => $this->image,
            'phone' => $this->phone_number,
            'price_per_hour' => $this->price_per_hour,
            'status' => $this->status,
            'portfolio_links' =>$this->portfolio_links,
            'rating_display' => $this->review,

            'skills' => $this->whenLoaded('skills', function() {
            return $this->skills->map(fn($skill) => [
                'name' => $skill->name,
                'experience' => $skill->pivot->experience_years
            ]);
        }),
        'joined_at' => $this->joined_at,
        'projects_count' => $this->completed_projects_count ?? 0,
        ];
    }
}

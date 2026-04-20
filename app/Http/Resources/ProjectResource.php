<?php

namespace App\Http\Resources;

use App\Http\Resources\AttachmentResource;
use App\Http\Resources\TagResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'title' => $this->title,
            'client' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ],
            'description' => $this->description,
            'budget_type' => $this->budget_type,
            'budget' => $this->budget,
            'deadline' => $this->deadline,
            'status' => $this->status,
            'offers_count' => $this->offers_count,
            'accepted_offer_id' => $this->accepted_offer_id,
            'rating' => round($this->user->reviews_received_avg_rating ?? 0, 1),
            'offers_count' => $this->offers_count ?? 0,
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            'attachments' => AttachmentResource::collection($this->whenLoaded('attachments')),
            'created_at' => $this->created_at->diffForHumans(),


        ];
    }
}

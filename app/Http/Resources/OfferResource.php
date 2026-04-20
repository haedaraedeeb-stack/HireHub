<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
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
            'price' => $this->price,
            'delivery_days' => $this->delivery_days,
            'status' => $this->status,
            'letter' => $this->letter,
            'freelancer' => new FreelancerResource($this->whenLoaded('freelancer')),
            'project' => new ProjectResource($this->whenLoaded('project')),
            'attachments' => AttachmentResource::collection($this->whenLoaded('attachments')),
            'created_at' => $this->created_at->format('Y-m-d H:i'),
            $this->mergeWhen($this->status === 'accepted', [
                'accepted_at' => $this->updated_at->format('Y-m-d H:i'),
            ]),
        ];
    }
}

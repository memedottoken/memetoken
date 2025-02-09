<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Msg extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'launchpad_id' => $this->launchpad_id,
            'uuid' => $this->uuid,
            'message' => $this->message,
            'image' => $this->image,
            'pinned' => $this->pinned,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'launchpad' => new Launchpad($this->whenLoaded('launchpad')),
            'user' => new ViewUser($this->whenLoaded('user')),
            'can' => [
                'delete' => $request->user()?->id === $this->user_id ||
                    $request->user()?->isAdmin(),
                'moderate' => $request->user()?->isAdmin(),
            ],
        ];
    }
}

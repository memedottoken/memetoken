<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Launchpad extends JsonResource
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
            'factory_id' => $this->factory_id,
            'contract' => $this->contract,
            'token' => $this->token,
            'name' => $this->name,
            'symbol' => $this->symbol,
            'description' => $this->description,
            'chainId' => (int) $this->chainId,
            'twitter' => $this->twitter,
            'discord' => $this->discord,
            'telegram' => $this->telegram,
            'website' => $this->website,
            'livestreamId' => $this->livestreamId,
            'status' => $this->status,
            'logo' => $this->logo,
            'featured' => $this->featured,
            'kingofthehill' => $this->kingofthehill,
            'active' => $this->active,
            'volume24h' => $this->volume24h ?? '0.00',
            'age' => $this->created_at->diffForHumans(),
            'trades_count' => $this->trades_count,
            'holders_count' => $this->holders_count,
            // to be pulled
            'percentage' => 0,
            'marketCap' => 0,
            'isFinalized' => false,
            'isOwner' => $this->user_id === $request->user()?->id,
            'createdAgo' => $this->created_at->diffForHumans(),
            'factory' => new Factory($this->whenLoaded('factory')),
            'user' => new ViewUser($this->whenLoaded('user')),
            'trades' => Trade::collection($this->whenLoaded('trades')),
            'msgs' => Msg::collection($this->whenLoaded('msgs')),
            'uploads' => Upload::collection($this->whenLoaded('uploads')),

        ];
    }
}

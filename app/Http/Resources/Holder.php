<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Holder extends JsonResource
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
            'launchpad_id' => $this->launchpad_id,
            'user_id' => $this->user_id,
            'address' => $this->address,
            'percentage' => bcdiv(bcmul("$this->qty", "100", 18), '1000000000', 4),
            'qty' => $this->qty,
            'prebond' => $this->prebond,
            'launchpad' => new Launchpad($this->whenLoaded('launchpad')),
            'user' => new User($this->whenLoaded('user')),
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Rate extends JsonResource
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
			'symbol'=>$this->symbol,
			'chainId'=>$this->chainId,
			'usd_rate'=>$this->usd_rate,

		];
    }
}

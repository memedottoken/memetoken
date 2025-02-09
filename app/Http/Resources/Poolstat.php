<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Poolstat extends JsonResource
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
			'launchpad_id'=>$this->launchpad_id,
			'token0_price'=>$this->token0_price,
			'token1_price'=>$this->token1_price,
			'tvl_usd'=>$this->tvl_usd,
			'volume_24h'=>$this->volume_24h,
			'fee_tier'=>$this->fee_tier,
			'transactions_24h'=>$this->transactions_24h,
			'total_transactions'=>$this->total_transactions,
			'liquidity'=>$this->liquidity,
			'price_change_1h'=>$this->price_change_1h,
			'price_change_24h'=>$this->price_change_24h,
			'price_change_7d'=>$this->price_change_7d,
			'min_price_24h'=>$this->min_price_24h,
			'max_price_24h'=>$this->max_price_24h,
			'timestamp'=>$this->timestamp,
			'launchpad'=> new Launchpad($this->whenLoaded('launchpad')),
		];
    }
}

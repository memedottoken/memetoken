<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TradeCandle extends JsonResource
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
            'launchpad_id' => $this->launchpad_id,
            'timeframe' => $this->timeframe,
            'timestamp' =>  $this->timestamp->timestamp,
            'open' => $this->open,
            'high' => $this->high,
            'low' => $this->low,
            'close' => $this->close,
            'volume' => $this->volume,
            'trades_count' => $this->trades_count,
        ];
    }
}

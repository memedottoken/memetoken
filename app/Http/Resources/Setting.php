<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Setting extends JsonResource
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
			'logo'=>$this->logo,
			'name'=>$this->name,
			'twitter'=>$this->twitter,
			'youtube'=>$this->youtube,
			'telegram_group'=>$this->telegram_group,
			'telegram_channel'=>$this->telegram_channel,
			'discord'=>$this->discord,
			'documentation'=>$this->documentation,
			'rpc'=>$this->rpc,
			'ankr'=>$this->ankr,
			'infura'=>$this->infura,
			'blast'=>$this->blast,
			'chat'=>$this->chat,
			'featured'=>$this->featured,

		];
    }
}

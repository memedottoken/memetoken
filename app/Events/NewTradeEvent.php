<?php

namespace App\Events;

use App\Http\Resources\Trade as ResourcesTrade;
use App\Models\Trade;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewTradeEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $trade;

    public function __construct(Trade $trade)
    {
        $this->trade = $trade;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('launchpad.' . $this->trade->launchpad_id),
            new Channel('trades'),
        ];
    }

    public function broadcastWith(): array
    {
        $launchpad = $this->trade->launchpad()->first();
        return [
            'id' => $this->trade->id,
            'launchpad_id' => $this->trade->launchpad_id,
            'txid' => $this->trade->txid,
            'qty' => $this->trade->qty,
            'usd' => $this->trade->usd,
            'amount' => $this->trade->amount,
            'address' => $this->trade->address,
            'type' => $this->trade->type,
            'price' => bcdiv($this->trade->amount, $this->trade->qty, 18),
            'usd_price' => bcdiv($this->trade->usd, $this->trade->qty, 8),
            'created_at' => $this->trade->created_at,
            'date' => now()->gt($this->trade->created_at->addDays(7))
                ? $this->trade->created_at->toDateTimeString()
                : $this->trade->created_at->diffForHumans(),
            'price' => bcdiv($this->trade->amount, $this->trade->qty, 18),
            //launchpad
            'contract' => $launchpad->contract,
            'token' => $launchpad->token,
            'name' => $launchpad->name,
            'symbol' => $launchpad->symbol,
            'description' => $launchpad->description,
            'chainId' => (int) $launchpad->chainId,
            'logo' => $launchpad->logo,
        ];
    }
}

<?php

namespace App\Observers;

use App\Models\Trade;
use App\Events\NewTradeEvent;
use App\Services\CandleService;

class TradeObserver
{
    protected $candleService;

    public function __construct(CandleService $candleService)
    {
        $this->candleService = $candleService;
    }

    /**
     * Handle the Trade "created" event.
     */
    public function created(Trade $trade): void
    {
        
        NewTradeEvent::dispatch($trade);
        // Update current period candles
        $this->candleService->updateCurrentPeriod($trade);
    }
}

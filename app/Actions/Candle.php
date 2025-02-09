<?php

namespace App\Actions;


use App\Models\Trade;
use App\Models\TradeCandle;
use Illuminate\Support\Facades\Cache;

class Candle
{
    /**
     * The mapping of timeframe identifiers to their duration in seconds.
     *
     * @var array<string, int>
     */
    public $timeframeSeconds = [
        '1m' => 60,
        '5m' => 300,
        '15m' => 900,
        '1h' => 3600,
        '4h' => 14400,
        '1d' => 86400,
    ];

    /**
     * Update or create a candle for each timeframe based on a new trade.
     * This method is called internally when a new trade is created.
     *
     * @param  \App\Models\Trade  $trade
     * @return void
     *
     * @throws \Exception When calculation errors occur
     *
     * Side effects:
     * - Creates or updates candles in the trade_candles table
     * - Clears related cache entries
     * - Updates all timeframe candles (1m, 5m, 15m, 1h, 4h, 1d)
     */
    public function update(Trade $trade)
    {
        foreach ($this->timeframeSeconds as $timeframe => $seconds) {
            $timestamp = $trade->created_at->timestamp;
            $intervalStart = $timestamp - ($timestamp % $seconds);
            $candle = TradeCandle::firstOrNew([
                'launchpad_id' => $trade->launchpad_id,
                'timeframe' => $timeframe,
                'timestamp' => date('Y-m-d H:i:s', $intervalStart)
            ]);
            $price = bcdiv($trade->amount, $trade->qty, 18);
            if (!$candle->exists) {
                $candle->open = $price;
                $candle->high = $price;
                $candle->low = $price;
                $candle->volume = $trade->qty;
                $candle->trades_count = 1;
            } else {
                $candle->high = max($candle->high, $price);
                $candle->low = min($candle->low, $price);
                $candle->volume = bcadd($candle->volume, $trade->qty, 18);
                $candle->trades_count++;
            }
            $candle->close = $price;
            $candle->save();
            // Clear the cache for this timeframe
            Cache::forget("candles:{$trade->launchpad_id}:{$timeframe}:200");
        }
        // Clear price stats cache
        Cache::forget("price_stats:{$trade->launchpad_id}");
    }
}

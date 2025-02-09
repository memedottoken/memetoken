<?php

namespace App\Services;

use App\Http\Resources\TradeCandle as ResourcesTradeCandle;
use App\Models\Trade;
use App\Models\TradeCandle;
use App\Models\Launchpad;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CandleService
{
    private array $timeframes = [
        '1' => 60,
        '5' => 300,
        '15' => 900,
        '30' => 1800,
        '60' => 3600,
        '240' => 14400,
        'D' => 86400,
        'W' => 604800
    ];

    /**
     * Update candles for all timeframes for a specific period
     */
    public function updateCandles(Launchpad $launchpad, Carbon $from, Carbon $to): void
    {
        foreach ($this->timeframes as $timeframe => $seconds) {
            $this->updateCandlesForTimeframe($launchpad, $timeframe, $from, $to);
        }
    }

    /**
     * Update candles for a specific timeframe
     */
    private function updateCandlesForTimeframe(Launchpad $launchpad, string $timeframe, Carbon $from, Carbon $to): void
    {
        $timeframeSeconds = $this->timeframes[$timeframe];
        DB::statement("SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
        // Get all trades within the period
        $candles = DB::table('trades')
            ->select([
                DB::raw("FLOOR(UNIX_TIMESTAMP(created_at) / $timeframeSeconds) * $timeframeSeconds as timestamp"),
                DB::raw('MIN(amount) as low'),
                DB::raw('MAX(amount) as high'),
                DB::raw('FIRST_VALUE(amount) OVER (PARTITION BY FLOOR(UNIX_TIMESTAMP(created_at) / ' . $timeframeSeconds . ') ORDER BY created_at ASC) as open'),
                DB::raw('FIRST_VALUE(amount) OVER (PARTITION BY FLOOR(UNIX_TIMESTAMP(created_at) / ' . $timeframeSeconds . ') ORDER BY created_at DESC) as close'),
                DB::raw('SUM(qty) as volume'),
                DB::raw('COUNT(*) as trades_count')
            ])
            ->where('launchpad_id', $launchpad->id)
            ->whereBetween('created_at', [$from, $to])
            ->groupBy(DB::raw("FLOOR(UNIX_TIMESTAMP(created_at) / $timeframeSeconds) * $timeframeSeconds"))
            ->get();

        foreach ($candles as $candle) {
            TradeCandle::updateOrCreate(
                [
                    'launchpad_id' => $launchpad->id,
                    'timeframe' => $timeframe,
                    'timestamp' => Carbon::createFromTimestamp($candle->timestamp),
                ],
                [
                    'open' => $candle->open,
                    'high' => $candle->high,
                    'low' => $candle->low,
                    'close' => $candle->close,
                    'volume' => $candle->volume,
                    'trades_count' => $candle->trades_count,
                ]
            );
        }
    }

    /**
     * Update current period candle
     */
    public function updateCurrentPeriod(Trade $trade): void
    {
        $now = Carbon::now();

        foreach ($this->timeframes as $timeframe => $seconds) {
            $periodStart = Carbon::createFromTimestamp(floor($now->timestamp / $seconds) * $seconds);
            $periodEnd = $periodStart->copy()->addSeconds($seconds);
            $this->updateCandlesForTimeframe($trade->launchpad, $timeframe, $periodStart, $periodEnd);
        }
    }

    /**
     * Get candles for TradingView
     */
    public function getCandles(Launchpad $launchpad, string $timeframe, Carbon $from, Carbon $to)
    {
        // Get historical completed candles from the database
        $candles = TradeCandle::where('launchpad_id', $launchpad->id)
            ->where('timeframe', $timeframe)
            ->whereBetween('timestamp', [$from, $to])
            ->orderBy('timestamp')
            ->get();

        // For the current period, calculate in real-time
        $currentPeriodStart = $this->getCurrentPeriodStart($timeframe);
        if ($to > $currentPeriodStart) {
            $currentCandle = $this->calculateCurrentCandle($launchpad, $timeframe, $currentPeriodStart);
            if ($currentCandle) {
                $candles->push($currentCandle);
            }
        }

        return ResourcesTradeCandle::collection($candles);
    }

    /**
     * Calculate the current incomplete candle
     */
    private function calculateCurrentCandle(Launchpad $launchpad, string $timeframe, Carbon $from): ?TradeCandle
    {
        $trades = Trade::where('launchpad_id', $launchpad->id)
            ->where('created_at', '>=', $from)
            ->get();

        if ($trades->isEmpty()) {
            return null;
        }

        return new TradeCandle([
            'launchpad_id' => $launchpad->id,
            'timeframe' => $timeframe,
            'timestamp' => $from,
            'open' => $trades->first()->amount,
            'high' => $trades->max('amount'),
            'low' => $trades->min('amount'),
            'close' => $trades->last()->amount,
            'volume' => $trades->sum('qty'),
            'trades_count' => $trades->count(),
        ]);
    }

    /**
     * Get the start of the current period
     */
    private function getCurrentPeriodStart(string $timeframe): Carbon
    {
        $seconds = $this->timeframes[$timeframe] ?? 3600;
        return Carbon::createFromTimestamp(floor(Carbon::now()->timestamp / $seconds) * $seconds);
    }
}

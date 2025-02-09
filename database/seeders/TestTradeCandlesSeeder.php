<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestTradeCandlesSeeder extends Seeder
{
    public function run(): void
    {
        $launchpadId = 2;
        $startDate = Carbon::now()->subDays(30);
        $timeframes = ['1', '5', '15', '30', '60', '240', 'D'];

        // Base price and parameters for random walk
        $basePrice = 0.001; // Starting price in ETH
        $volatility = 0.02; // 2% average price movement
        $trendStrength = 0.6; // 60% chance to follow trend
        $trend = 1; // Start with upward trend

        foreach ($timeframes as $timeframe) {
            $interval = $this->getIntervalInSeconds($timeframe);
            $records = [];
            $currentPrice = $basePrice;
            $timestamp = $startDate->copy();

            // Calculate number of candles based on timeframe
            $totalCandles = ceil($startDate->diffInSeconds(Carbon::now()) / $interval);

            for ($i = 0; $i < $totalCandles; $i++) {
                // Randomly switch trend with 20% probability
                if (rand(1, 100) <= 20) {
                    $trend *= -1;
                }

                // Calculate price movement
                $movement = $currentPrice * $volatility * (rand(1, 100) <= ($trendStrength * 100) ? $trend : -$trend);
                $movement *= (rand(0, 100) / 100); // Randomize movement magnitude

                // Calculate OHLCV data
                $open = $currentPrice;
                $close = $currentPrice + $movement;
                $high = max($open, $close) * (1 + (rand(0, 100) / 1000)); // Up to 0.1% higher
                $low = min($open, $close) * (1 - (rand(0, 100) / 1000)); // Up to 0.1% lower
                $volume = rand(100, 1000) / pow(10, 18); // Random volume between 0.1 and 1 ETH

                $records[] = [
                    'launchpad_id' => $launchpadId,
                    'timestamp' => $timestamp->copy(),
                    'timeframe' => $timeframe,
                    'open' => number_format($open, 18, '.', ''),
                    'high' => number_format($high, 18, '.', ''),
                    'low' => number_format($low, 18, '.', ''),
                    'close' => number_format($close, 18, '.', ''),
                    'volume' => number_format($volume, 18, '.', ''),
                    'trades_count' => rand(1, 20),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];

                // Update current price for next iteration
                $currentPrice = $close;
                $timestamp->addSeconds($interval);

                // Insert in chunks to avoid memory issues
                if (count($records) >= 100) {
                    DB::table('trade_candles')->insert($records);
                    $records = [];
                }
            }

            // Insert remaining records
            if (!empty($records)) {
                DB::table('trade_candles')->insert($records);
            }
        }
    }

    private function getIntervalInSeconds(string $timeframe): int
    {
        return match ($timeframe) {
            '1' => 60,
            '5' => 300,
            '15' => 900,
            '30' => 1800,
            '60' => 3600,
            '240' => 14400,
            'D' => 86400,
            default => 3600,
        };
    }
}

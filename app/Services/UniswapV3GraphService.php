<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class UniswapV3GraphService
{

    protected Http $client;

    public function __construct(protected string $endpoint)
    {
        // Different endpoints for different networks
        $this->client = Http::timeout(30);
    }

    /**
     * Fetch pool statistics for a specific pool
     */
    public function getPoolStats(string $poolAddress): array
    {
        $query = '
            query GetPoolStats($poolAddress: String!, $startTime: Int!) {
                pool(id: $poolAddress) {
                    token0Price
                    token1Price
                    totalValueLockedUSD
                    feeTier
                    liquidity
                    txCount
                    volumeUSD
                    poolDayData(
                        first: 7
                        orderBy: date
                        orderDirection: desc
                        where: { date_gt: $startTime }
                    ) {
                        date
                        volumeUSD
                        tvlUSD
                        token0Price
                        token1Price
                        txCount
                    }
                }
            }
        ';

        try {
            $startTime = Carbon::now()->subDays(7)->startOfDay()->timestamp;

            $response = $this->client->post($this->endpoint, [
                'query' => $query,
                'variables' => [
                    'poolAddress' => strtolower($poolAddress),
                    'startTime' => $startTime
                ]
            ])->throw()->json();

            $pool = $response['data']['pool'] ?? null;
            if (!$pool) {
                throw new \Exception("Pool not found: {$poolAddress}");
            }

            $dayData = $pool['poolDayData'] ?? [];

            // Calculate price changes
            $priceChanges = $this->calculatePriceChanges($dayData, $pool['token0Price']);

            return [
                'token0_price' => $pool['token0Price'],
                'token1_price' => $pool['token1Price'],
                'tvl_usd' => $pool['totalValueLockedUSD'],
                'volume_24h' => $dayData[0]['volumeUSD'] ?? 0,
                'fee_tier' => $pool['feeTier'] / 10000, // Convert from basis points
                'transactions_24h' => $dayData[0]['txCount'] ?? 0,
                'total_transactions' => $pool['txCount'],
                'liquidity' => $pool['liquidity'],
                'price_change_1h' => $priceChanges['1h'],
                'price_change_24h' => $priceChanges['24h'],
                'price_change_7d' => $priceChanges['7d'],
                'min_price_24h' => $this->calculateMinPrice($dayData),
                'max_price_24h' => $this->calculateMaxPrice($dayData),
                'timestamp' => now()
            ];
        } catch (\Exception $e) {
            Log::error('Failed to fetch pool stats', [
                'pool' => $poolAddress,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Calculate price changes for different time periods
     */
    protected function calculatePriceChanges(array $dayData, string $currentPrice): array
    {
        $currentPrice = (float) $currentPrice;
        $changes = [
            '1h' => 0,
            '24h' => 0,
            '7d' => 0
        ];

        if (empty($dayData)) {
            return $changes;
        }

        // 24h change
        if (isset($dayData[0]['token0Price'])) {
            $price24hAgo = (float) $dayData[0]['token0Price'];
            $changes['24h'] = $this->calculatePercentageChange($price24hAgo, $currentPrice);
        }

        // 7d change
        if (isset($dayData[6]['token0Price'])) {
            $price7dAgo = (float) $dayData[6]['token0Price'];
            $changes['7d'] = $this->calculatePercentageChange($price7dAgo, $currentPrice);
        }

        // Note: 1h change requires additional query to get hourly data
        // You might want to add that separately if needed

        return $changes;
    }

    /**
     * Calculate minimum price in the last 24 hours
     */
    protected function calculateMinPrice(array $dayData): float
    {
        if (empty($dayData)) {
            return 0;
        }

        $prices = array_column($dayData, 'token0Price');
        return (float) min($prices);
    }

    /**
     * Calculate maximum price in the last 24 hours
     */
    protected function calculateMaxPrice(array $dayData): float
    {
        if (empty($dayData)) {
            return 0;
        }

        $prices = array_column($dayData, 'token0Price');
        return (float) max($prices);
    }

    /**
     * Calculate percentage change between two values
     */
    protected function calculatePercentageChange(float $oldValue, float $newValue): float
    {
        if ($oldValue == 0) {
            return 0;
        }

        return (($newValue - $oldValue) / $oldValue) * 100;
    }
}

<?php

namespace App\Console\Commands;

use App\Models\Launchpad;
use App\Services\CandleService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateTradeCandles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trades:update-candles {--days=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update historical trade candles';

    /**
     * Execute the console command.
     */
    public function handle(CandleService $candleService)
    {
        //
        $days = $this->option('days');
        $from = Carbon::now()->subDays($days)->startOfDay();
        $to = Carbon::now();
        $this->info("Updating candles from {$from} to {$to}");
        // Get active bonding curves
        $launchpads = Launchpad::query()->whereNull('pool')->get();
        foreach ($launchpads as $launchpad) {
            $this->info("Processing launchpad: {$launchpad->name} ({$launchpad->symbol})");
            try {
                $candleService->updateCandles($launchpad, $from, $to);
                $this->info("Successfully updated candles for {$launchpad->symbol}");
            } catch (\Exception $e) {
                $this->error("Error updating candles for {$launchpad->symbol}: {$e->getMessage()}");
            }
        }

        $this->info('Candle update completed');
    }
}

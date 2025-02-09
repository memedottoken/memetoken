<?php

namespace App\Console\Commands;

use App\Models\Launchpad;
use App\Models\Poolstat;
use App\Services\UniswapV3GraphService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdatePoolStats extends Command
{
    protected $signature = 'pool:update-stats {launchpad? : Specific launchpad ID to update}';
    protected $description = 'Update pool statistics from The Graph';


    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $links = collect(config('evm', []))
            ->values()
            ->reject(fn($evm) => !isset($evm['chainId']) || !isset($evm['graph']))
            ->pluck('graph', 'chainId')
            ->all();
        try {
            $launchpads = Launchpad::query()
                ->whereIn('chainId', array_keys($links))
                //->whereNotNull('graph')
                ->whereNotNull('pool')
                ->get();
            $bar = $this->output->createProgressBar($launchpads->count());
            $bar->start();

            foreach ($launchpads as $launchpad) {
                $graphLink =  $links[$launchpad->chainId];
                $url = str_replace('[api-key]', config('evm.graph_apikey'), $graphLink);
                $graphService = new UniswapV3GraphService($url);
                try {
                    $stats = $graphService->getPoolStats($launchpad->pool);
                    Poolstat::create([
                        'launchpad_id' => $launchpad->id,
                        ...$stats
                    ]);
                    $this->info(" Updated stats for launchpad {$launchpad->id}");
                } catch (\Exception $e) {
                    Log::error("Failed to update pool stats", [
                        'launchpad_id' => $launchpad->id,
                        'error' => $e->getMessage()
                    ]);
                    $this->error(" Failed to update launchpad {$launchpad->id}: {$e->getMessage()}");
                }
                $bar->advance();
            }
            $bar->finish();
            $this->newLine();
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Failed to update pool stats: {$e->getMessage()}");
            return Command::FAILURE;
        }
    }
}

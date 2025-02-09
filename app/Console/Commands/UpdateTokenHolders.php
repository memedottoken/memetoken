<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\TokenHolderService;

class UpdateTokenHolders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'launchpad:update-holders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update token holders for launchpads';

    /**
     * Execute the console command.
     */
    public function handle(TokenHolderService $service)
    {
        $service->updateAllHolders();
        $this->info('Updated holders for all active launchpads');
    }
}

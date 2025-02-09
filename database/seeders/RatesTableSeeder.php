<?php

namespace Database\Seeders;

use App\Models\Rate;
use App\Services\Rate as ServicesRate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        collect(config('evm'))->reject(function ($evm) {
            return !is_array($evm) || !isset($evm['chainId']) || !isset($evm['symbol']);
        })->map(function (array $evm) {
            Rate::query()->updateOrCreate(['chainId' => $evm['chainId']], [
                'chainId' => $evm['chainId'],
                'symbol' => $evm['symbol']
            ]);
        });
        ServicesRate::update();
    }
}

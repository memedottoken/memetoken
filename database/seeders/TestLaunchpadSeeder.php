<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TestLaunchpadSeeder extends Seeder
{
    private function generateRandomAddress(): string
    {
        // Ethereum addresses are 20 bytes (40 hex characters) long, prefixed with '0x'
        $characters = '0123456789abcdef';
        $randomHex = '';

        for ($i = 0; $i < 40; $i++) {
            $randomHex .= $characters[random_int(0, 15)];
        }

        return '0x' . $randomHex;
    }

    private function generateRandomTxHash(): string
    {
        // Ethereum transaction hashes are 32 bytes (64 hex characters) long, prefixed with '0x'
        $characters = '0123456789abcdef';
        $randomHex = '';

        for ($i = 0; $i < 64; $i++) {
            $randomHex .= $characters[random_int(0, 15)];
        }

        return '0x' . $randomHex;
    }

    public function run(): void
    {
        // Create sample launchpad
        $launchpadId = DB::table('launchpads')->insertGetId([
            'user_id' => 1,
            'factory_id' => 1,
            'contract' => $this->generateRandomAddress(),
            'token' => $this->generateRandomAddress(),
            'name' => 'Sample Token',
            'symbol' => 'SMPL',
            'description' => 'This is a sample token for testing purposes with innovative tokenomics and strong community focus.',
            'chainId' => '11155111',
            'twitter' => 'https://twitter.com/sampletoken',
            'discord' => 'https://discord.gg/sampletoken',
            'telegram' => 'https://t.me/sampletoken',
            'website' => 'https://sampletoken.io',
            'status' => 'bonding',
            'logo' => 'sample-logo.png',
            'featured' => true,
            'kingofthehill' => false,
            'active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create sample messages
        $messages = [
            'Excited about this project! The tokenomics look promising.',
            'When is the next community AMA?',
            'The development roadmap is impressive.',
            'Looking forward to the upcoming features!',
            'Great community engagement so far.'
        ];

        foreach ($messages as $message) {
            DB::table('msgs')->insert([
                'user_id' => 1,
                'launchpad_id' => $launchpadId,
                'uuid' => Str::uuid(),
                'message' => $message,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create sample trades
        $trades = [
            [
                'type' => 'prebond',
                'qty' => '1000',  // 1000 tokens with 18 decimals
                'amount' => '1',   // 1 ETH
            ],
            [
                'type' => 'buy',
                'qty' => '500',   // 500 tokens
                'amount' => '0.5',    // 0.5 ETH
            ],
            [
                'type' => 'sell',
                'qty' => '200',   // 200 tokens
                'amount' => '0.22',    // 0.22 ETH
            ],
        ];

        foreach ($trades as $trade) {
            DB::table('trades')->insert([
                'launchpad_id' => $launchpadId,
                'txid' => $this->generateRandomTxHash(),
                'address' => $this->generateRandomAddress(),
                'qty' => $trade['qty'],
                'amount' => $trade['amount'],
                'type' => $trade['type'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create sample holders
        $holders = [
            [
                'address' => $this->generateRandomAddress(),
                'qty' => '800',    // 800 tokens
                'prebond' => true,
                'user_id' => 1,
            ],
            [
                'address' => $this->generateRandomAddress(),
                'qty' => '500',    // 500 tokens
                'prebond' => false,
                'user_id' => null,
            ],
            [
                'address' => $this->generateRandomAddress(),
                'qty' => '300',    // 300 tokens
                'prebond' => false,
                'user_id' => null,
            ],
        ];

        foreach ($holders as $holder) {
            DB::table('holders')->insert([
                'launchpad_id' => $launchpadId,
                'user_id' => $holder['user_id'],
                'address' => $holder['address'],
                'qty' => $holder['qty'],
                'prebond' => $holder['prebond'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

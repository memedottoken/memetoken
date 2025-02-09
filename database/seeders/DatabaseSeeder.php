<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        Setting::query()->firstOrCreate([
            'id' => 1
        ], [
            'name' => 'Memex',
            'twitter' => "https://x.com/memex",
            'youtube' => "https://youtube.com/@memex",
            'telegram_group' => "https://t.me/memex",
            'telegram_channel' => "https://t.me/memex",
            'discord' => "https://discord.gg/memex",
            'documentation' => "https://docs.memex.io",
        ]);
        $this->call(RatesTableSeeder::class);
    }
}

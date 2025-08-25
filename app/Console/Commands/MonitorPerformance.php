<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class MonitorPerformance extends Command
{
    protected $signature = 'performance:monitor {--clear-cache}';
    protected $description = 'Monitor application performance';

    public function handle()
    {
        if ($this->option('clear-cache')) {
            $this->info('Clearing cache...');
            Cache::flush();
            $this->info('Cache cleared!');
            return;
        }

        $this->info('=== PERFORMANCE MONITOR ===');

        // Database stats
        $this->checkDatabaseStats();

        // Cache stats
        $this->checkCacheStats();

        // Memory usage
        $this->checkMemoryUsage();
    }

    private function checkDatabaseStats()
    {
        $this->info("\n📊 Database Stats:");

        // Count tables
        $tables = DB::select("SHOW TABLES");
        $this->line("Tables: " . count($tables));

        // Count records in key tables
        $foods = DB::table('food')->count();
        $users = DB::table('users')->count();
        $diaryEntries = DB::table('diary_entries')->count();

        $this->line("Foods: {$foods}");
        $this->line("Users: {$users}");
        $this->line("Diary Entries: {$diaryEntries}");
    }

    private function checkCacheStats()
    {
        $this->info("\n💾 Cache Stats:");

        if (config('cache.default') === 'redis') {
            try {
                $redis = app('redis');
                $info = $redis->info();
                $this->line("Redis Memory: " . ($info['used_memory_human'] ?? 'N/A'));
                $this->line("Redis Keys: " . ($info['db0']['keys'] ?? 'N/A'));
            } catch (\Exception $e) {
                $this->error("Redis error: " . $e->getMessage());
            }
        } else {
            $this->line("Cache Driver: " . config('cache.default'));
        }
    }

    private function checkMemoryUsage()
    {
        $this->info("\n🧠 Memory Usage:");
        $memory = memory_get_usage(true);
        $memoryPeak = memory_get_peak_usage(true);

        $this->line("Current: " . $this->formatBytes($memory));
        $this->line("Peak: " . $this->formatBytes($memoryPeak));
    }

    private function formatBytes($size, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        for ($i = 0; $size > 1024 && $i < count($units) - 1; $i++) {
            $size /= 1024;
        }
        return round($size, $precision) . ' ' . $units[$i];
    }
}

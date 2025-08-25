<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\RateLimiter;

class MonitorRateLimits extends Command
{
    protected $signature = 'rate-limit:monitor {--endpoint=}';
    protected $description = 'Monitor rate limits (works with any cache driver)';

    public function handle()
    {
        $this->info('=== RATE LIMIT MONITOR ===');
        $this->info('This works with any cache driver');
        $this->info('Use: php artisan rate-limit:monitor --endpoint=api_key_here');

        $endpoint = $this->option('endpoint');

        if ($endpoint) {
            $this->checkSpecificEndpoint($endpoint);
        } else {
            $this->info('Provide endpoint key to monitor. Example:');
            $this->line('php artisan rate-limit:monitor --endpoint=api|127.0.0.1');
        }
    }

    private function checkSpecificEndpoint($key)
    {
        try {
            $attempts = RateLimiter::attempts($key);
            $this->info("Key: {$key}");
            $this->info("Attempts: {$attempts}");

            if (RateLimiter::tooManyAttempts($key, 60)) { // 60 adalah max attempts
                $availableIn = RateLimiter::availableIn($key);
                $this->error("RATE LIMITED! Available in: {$availableIn} seconds");
            } else {
                $this->info("Not rate limited");
            }
        } catch (\Exception $e) {
            $this->error("Error checking rate limit: " . $e->getMessage());
        }
    }
}

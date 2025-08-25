<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\RateLimiter;

class TestRateLimit extends Command
{
    protected $signature = 'rate-limit:test';
    protected $description = 'Test rate limiting functionality';

    public function handle()
    {
        $key = 'test-key';
        $maxAttempts = 5;
        $decayMinutes = 1;

        for ($i = 1; $i <= 7; $i++) {
            $attempts = RateLimiter::attempts($key);
            $remaining = $maxAttempts - $attempts;

            if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
                $this->error("Attempt {$i}: Rate limited! Remaining: {$remaining}");
                $this->line("Available in: " . RateLimiter::availableIn($key) . " seconds");
            } else {
                RateLimiter::hit($key, $decayMinutes);
                $this->info("Attempt {$i}: Success! Remaining: {$remaining}");
            }

            sleep(1);
        }

        // Clear rate limit
        RateLimiter::clear($key);
        $this->info('Rate limit cleared.');
    }
}

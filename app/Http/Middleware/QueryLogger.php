<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QueryLogger
{
    public function handle(Request $request, Closure $next)
    {
        if (config('app.debug') && $request->is('api/*')) {
            DB::enableQueryLog();
        }

        $response = $next($request);

        if (config('app.debug') && $request->is('api/*')) {
            $queries = DB::getQueryLog();
            $totalTime = collect($queries)->sum('time');

            if ($totalTime > 100) { // Log if queries take more than 100ms
                Log::warning('Slow API Query', [
                    'path' => $request->path(),
                    'method' => $request->method(),
                    'total_queries' => count((array) $queries),
                    'total_time_ms' => $totalTime,
                    'queries' => $queries
                ]);
            }

            DB::disableQueryLog();
        }

        return $response;
    }
}

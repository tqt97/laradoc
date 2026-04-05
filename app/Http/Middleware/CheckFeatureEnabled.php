<?php

namespace App\Http\Middleware;

use App\Services\Feature;
use Closure;
use Illuminate\Http\Request;

class CheckFeatureEnabled
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $feature)
    {
        if (! app(Feature::class)->isGlobalEnabled($feature)) {
            abort(404);
        }

        return $next($request);
    }
}

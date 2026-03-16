<?php

namespace App\Http\Middleware;

use App\Services\Feature;
use Closure;
use Illuminate\Http\Request;

class CheckFeature
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $feature)
    {
        if (! app(Feature::class)->isEnabled($feature)) {
            abort(404);
        }

        return $next($request);
    }
}

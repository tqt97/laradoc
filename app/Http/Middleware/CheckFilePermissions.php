<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckFilePermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $action): Response
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Super Admin bypass
        if ($user->hasRole('super-admin')) {
            return $next($request);
        }

        // Action-based checks
        return match ($action) {
            'review', 'approve', 'reject' => $this->checkAdminAccess($user, $next, $request),
            default => abort(403, 'Unauthorized action.'),
        };
    }

    private function checkAdminAccess($user, $next, $request)
    {
        if ($user->hasRole('admin')) {
            return $next($request);
        }

        abort(403, 'Bạn không có quyền thực hiện hành động này.');
    }
}

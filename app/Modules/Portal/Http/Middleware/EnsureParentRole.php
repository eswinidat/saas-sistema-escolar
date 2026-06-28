<?php

namespace App\Modules\Portal\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureParentRole
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()?->hasRole('Padre')) {
            abort(403, 'Acceso exclusivo para apoderados.');
        }

        if ($request->user()->school_id) {
            app()->instance('current_school_id', $request->user()->school_id);
        }

        return $next($request);
    }
}

<?php

namespace App\Modules\Core\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetSchoolContext
{
    public function handle(Request $request, Closure $next): Response
    {
        $schoolId = null;

        if ($request->user()) {
            if ($request->user()->hasRole('Super Administrador')) {
                $schoolId = $request->session()->get('current_school_id');

                if ($request->filled('school_id')) {
                    $schoolId = (int) $request->input('school_id');
                    $request->session()->put('current_school_id', $schoolId);
                }
            } else {
                $schoolId = $request->user()->school_id;
            }
        }

        app()->instance('current_school_id', $schoolId);

        return $next($request);
    }
}

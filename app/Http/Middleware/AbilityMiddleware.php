<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AbilityMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $ability)
    {
        $employee = auth()->user()->employee;

        if($employee->can($ability)) {
            return $next($request);
        }
        
        return response()->json([
            'success' => false,
            'message' => "You can't complete this action."
        ],Response::HTTP_FORBIDDEN);
    }
}

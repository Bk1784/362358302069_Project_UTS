<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DisableCsrfForApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Skip CSRF validation untuk route API
        if ($request->is('api/*')) {
            \Session::forget('token'); // Hapus CSRF token dari session
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use App\Models\Reel;
use Closure;
use Illuminate\Http\Request;

class ImageRequestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {

        $requestUri = $request->getRequestUri();

        // Example usage
        if ($requestUri === '/api/reels') {
            // Perform your logic here
            dd('ok');
        }


        return $next($request);
    }
}

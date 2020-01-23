<?php

namespace QikkerOnline\NovaMenuBuilder\Http\Middleware;

use QikkerOnline\NovaMenuBuilder\NovaMenuBuilder;

class Authorize
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next)
    {
        return resolve(NovaMenuBuilder::class)->authorize($request) ? $next($request) : abort(403);
    }
}

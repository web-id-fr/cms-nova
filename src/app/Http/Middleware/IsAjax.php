<?php

namespace Webid\CmsNova\App\Http\Middleware;

class IsAjax
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        if ($request->ajax()) {
            return $next($request);
        }
        abort(403, 'Access denied');
    }
}

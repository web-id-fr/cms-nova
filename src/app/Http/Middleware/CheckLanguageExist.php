<?php

namespace Webid\CmsNova\App\Http\Middleware;

use Illuminate\Http\Request;

class CheckLanguageExist
{
    /**
     * @return mixed
     */
    public function handle(Request $request, \Closure $next)
    {
        /** @var string $lang */
        $lang = $request->route('lang');
        if (! array_key_exists($lang, config('cms.locales'))) {
            abort(404);
        }

        return $next($request);
    }
}

<?php

namespace Webid\CmsNova\App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Webid\CmsNova\App\Services\LanguageService;

class Language
{
    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
     */
    public function handle(Request $request, \Closure $next)
    {
        $explodedPath = array_filter(explode('/', $request->path()));

        $locale = $request->lang
            ?? array_shift($explodedPath)
            ?? null;

        if (null === $locale) {
            return redirect(app(LanguageService::class)->getFromBrowser());
        }
        app()->setLocale($locale);
        URL::defaults(['lang' => $locale]);

        return $next($request);
    }
}

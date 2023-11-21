<?php

namespace Webid\CmsNova\App\Http\Middleware;

use Illuminate\Http\Request;
use Webid\CmsNova\App\Services\TemplateService;

class RedirectToHomepage
{
    private TemplateService $templateService;

    public function __construct(TemplateService $templateService)
    {
        $this->templateService = $templateService;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
     */
    public function handle(Request $request, \Closure $next)
    {
        $path = request()->path();
        $slugs = explode('/', $path);
        $lastSlug = end($slugs);

        if ($this->templateService->getHomepageSlug() == $lastSlug) {
            return redirect(route('home'), 301);
        }

        return $next($request);
    }
}

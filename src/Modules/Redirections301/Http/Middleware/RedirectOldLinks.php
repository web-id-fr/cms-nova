<?php

namespace Webid\CmsNova\Modules\Redirections301\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Webid\CmsNova\Modules\Redirections301\Repositories\RedirectionRepository;

class RedirectOldLinks
{
    public function __construct(private RedirectionRepository $repository)
    {
    }

    /**
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, $next)
    {
        $redirection = $this->repository->findBySourcePath($request->path());

        if (! is_null($redirection)) {
            return Redirect::to($redirection->destination_url, 301);
        }

        return $next($request);
    }
}

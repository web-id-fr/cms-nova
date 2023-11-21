<?php

namespace Webid\CmsNova\App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Webid\CmsNova\App\Services\Sitemap\SitemapGenerator;

class SitemapController extends BaseController
{
    public function __construct(private SitemapGenerator $sitemap)
    {
    }

    public function index(Request $request): Response
    {
        return $this->sitemap->generate()->toResponse($request);
    }
}

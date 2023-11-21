<?php

namespace Webid\CmsNova\App\Services\Sitemap;

/**
 * @property-read string $lang
 * @property-read string $path
 */
class SitemapUrlAlternate
{
    public string $lang;
    public string $path;

    public function __construct(string $lang, string $path)
    {
        $this->lang = $lang;
        $this->path = $path;
    }
}

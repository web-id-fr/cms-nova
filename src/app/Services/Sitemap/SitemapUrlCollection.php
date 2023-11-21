<?php

namespace Webid\CmsNova\App\Services\Sitemap;

class SitemapUrlCollection
{
    /** @var SitemapUrl[] */
    private array $urls;

    public function __construct()
    {
        $this->urls = [];
    }

    public function push(SitemapUrl $url): void
    {
        array_push($this->urls, $url);
    }

    /**
     * @return SitemapUrl[]
     */
    public function all(): array
    {
        return $this->urls;
    }
}

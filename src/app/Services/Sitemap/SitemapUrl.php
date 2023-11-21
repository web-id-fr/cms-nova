<?php

namespace Webid\CmsNova\App\Services\Sitemap;

/**
 * @property-read string $path
 * @property-read \DateTime $updated_at
 * @property-read SitemapUrlAlternate[] $alternates
 */
class SitemapUrl
{
    public string $path;
    public \DateTime $updated_at;
    public array $alternates;

    public function __construct(string $path, \DateTime $updated_at, array $alternates = [])
    {
        $this->path = $path;
        $this->updated_at = $updated_at;
        $this->alternates = $alternates;
    }

    public function setAlternates(array $alternates): void
    {
        $this->alternates = $alternates;
    }
}

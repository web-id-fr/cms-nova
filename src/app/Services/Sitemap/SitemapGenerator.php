<?php

namespace Webid\CmsNova\App\Services\Sitemap;

use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Webid\CmsNova\App\Repositories\PageRepository;

class SitemapGenerator
{
    /** @var array|\Closure[] */
    protected array $closures;

    public function __construct(private PageRepository $templateRepository)
    {
        $this->closures = [];
    }

    public function addCallback(\Closure $closure): void
    {
        array_push($this->closures, $closure);
    }

    /**
     * @throws \Exception
     */
    public function generate(): Sitemap
    {
        $sitemap = Sitemap::create();

        $urlsCollection = new SitemapUrlCollection();
        $urlsCollection = $this->loadPublishedPagesUrls($urlsCollection);
        $urlsCollection = $this->loadAdditionalUrlsFromCallbacks($urlsCollection);

        foreach ($urlsCollection->all() as $urlToAdd) {
            $url = Url::create($urlToAdd->path)
                ->setLastModificationDate($urlToAdd->updated_at)
                ->setChangeFrequency('')
                ->setPriority(0)
            ;

            foreach ($urlToAdd->alternates as $alternate) {
                $url->addAlternate($alternate->path, $alternate->lang);
            }

            $sitemap->add($url);
        }

        return $sitemap;
    }

    /**
     * @throws \Exception
     */
    private function loadAdditionalUrlsFromCallbacks(SitemapUrlCollection $collection): SitemapUrlCollection
    {
        foreach ($this->closures as $closure) {
            $returnValues = $closure();

            if (! is_array($returnValues)) {
                throw new \Exception('Returned values for sitemap closure must be an array !');
            }

            foreach ($returnValues as $url) {
                $collection->push($url);
            }
        }

        return $collection;
    }

    private function loadPublishedPagesUrls(SitemapUrlCollection $collection): SitemapUrlCollection
    {
        foreach ($this->templateRepository->getPublishedAndIndexedPages() as $template) {
                if ($template->homepage) {
                    $path = '/';
                } else {
                    $fullPath = $template->getFullPath('/');
                    $path = "{$fullPath}";
                }

                $collection->push(new SitemapUrl($path, $template->updated_at));
        }

        return $collection;
    }
}

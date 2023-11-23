<?php

namespace Webid\CmsNova\Modules\Articles\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Webid\CmsNova\App\Repositories\PageRepository;
use Webid\CmsNova\App\Services\LanguageService;
use Webid\CmsNova\App\Services\Sitemap\SitemapGenerator;
use Webid\CmsNova\App\Services\Sitemap\SitemapUrl;
use Webid\CmsNova\App\Services\Sitemap\SitemapUrlAlternate;
use Webid\CmsNova\Modules\Articles\Models\ArticleCategory;
use Webid\CmsNova\Modules\Articles\Repositories\ArticleCategoryRepository;
use Webid\CmsNova\Modules\Articles\Repositories\ArticleRepository;

class SitemapServiceProvider extends ServiceProvider
{
    private readonly SitemapGenerator $sitemap;
    private readonly ArticleRepository $articleRepository;
    private readonly ArticleCategoryRepository $categoryRepository;
    private readonly PageRepository $templateRepository;

    public function boot(
        SitemapGenerator $sitemap,
        ArticleRepository $articleRepository,
        ArticleCategoryRepository $categoryRepository,
        LanguageService $languageService,
        PageRepository $templateRepository
    ) {
        $this->sitemap = $sitemap;
        $this->articleRepository = $articleRepository;
        $this->categoryRepository = $categoryRepository;
        $this->templateRepository = $templateRepository;

        $this->sitemap->addCallback(function () use ($languageService) {
            return $this->registerSitemapableUrls(
                $languageService->getUsedLanguagesSlugs()
            );
        });
    }

    /**
     * @param string[] $usedLangs
     */
    protected function registerSitemapableUrls(array $usedLangs): array
    {
        return array_merge(
            $this->registerArticlesPages($usedLangs),
            $this->registerCategoriesPages($usedLangs)
        );
    }

    /**
     * @param string[] $usedLangs
     */
    private function registerArticlesPages(array $usedLangs): array
    {
        $urls = [];
        $alternates = [];

        foreach ($this->articleRepository->getPublishedArticles() as $article) {
            $slugs = $article->getTranslations('slug');

            foreach ($usedLangs as $lang) {
                if (! isset($slugs[$lang])) {
                    continue;
                }

                $path = route('articles.show', [
                    'lang' => $lang,
                    'slug' => $slugs[$lang],
                ]);

                $urls[$article->id][] = new SitemapUrl(
                    $path,
                    $article->updated_at
                );
                $alternates[$article->id][] = new SitemapUrlAlternate($lang, $path);
            }

            foreach ($urls as $article_id => $urls_for_article) {
                foreach ($urls_for_article as $url) {
                    $url->setAlternates($alternates[$article_id]);
                }
            }
        }

        return Arr::flatten($urls);
    }

    /**
     * @param string[] $usedLangs
     */
    private function registerCategoriesPages(array $usedLangs): array
    {
        $urls = [];

        $pagesContainingArticlesLists = $this->templateRepository->getPublicPagesContainingArticlesLists();

        foreach ($pagesContainingArticlesLists as $page) {
            foreach ($this->categoryRepository->all() as $category) {
                $urls = array_merge(
                    $urls,
                    $this->generateUrlsForPageAndCategory($usedLangs, $page, $category)
                );
            }
        }

        return $urls;
    }

    private function generateUrlsForPageAndCategory(array $usedLangs, Template $page, ArticleCategory $category): array
    {
        $urls = [];
        $alternates = [];

        $slugs = $page->getTranslations('slug');
        $names = $category->getTranslations('name');

        foreach ($usedLangs as $lang) {
            if (! isset($names[$lang]) || ! isset($slugs[$lang])) {
                continue;
            }

            if ($page->isHomepage()) {
                $path = route('home', [
                    'lang' => $lang,
                    'category' => $names[$lang],
                ]);
            } else {
                $path = "{$lang}/{$slugs[$lang]}?category={$names[$lang]}";
            }

            $urls[] = new SitemapUrl(
                $path,
                $category->updated_at
            );
            $alternates[] = new SitemapUrlAlternate($lang, $path);
        }

        foreach ($urls as $url) {
            $url->setAlternates($alternates);
        }

        return $urls;
    }
}

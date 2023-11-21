<?php

namespace Webid\CmsNova\Modules\Articles\Observers;

use Webid\CmsNova\App\Observers\Traits\GenerateTranslatableSlugIfNecessary;
use Webid\CmsNova\Modules\Articles\Models\Article;
use Webid\CmsNova\Modules\Articles\Repositories\ArticleRepository;

class ArticleObserver
{
    use GenerateTranslatableSlugIfNecessary;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->repository = $articleRepository;
    }

    public function saving(Article $article): void
    {
        $titles = $article->getTranslations('title');
        $originalSlug = $article->getOriginal('slug') ?? [];
        $value = $article->getTranslations('slug');

        $allSlug = $this->generateMissingSlugs($originalSlug, $value, $titles);

        $article->slug = $allSlug;
    }
}

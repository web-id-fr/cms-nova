<?php

namespace Webid\CmsNova\Modules\Articles\Tests\Helpers;

use Webid\CmsNova\Modules\Articles\Models\ArticleCategory;

trait ArticleCategoryCreator
{
    protected function createArticleCategory(array $parameters = []): ArticleCategory
    {
        return ArticleCategory::factory($parameters)->create();
    }
}

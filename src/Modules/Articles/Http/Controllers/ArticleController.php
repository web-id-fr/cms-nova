<?php

namespace Webid\CmsNova\Modules\Articles\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Webid\CmsNova\App\Http\Controllers\BaseController;
use Webid\CmsNova\Modules\Articles\Http\Resources\ArticleResource;
use Webid\CmsNova\Modules\Articles\Repositories\ArticleRepository;

class ArticleController extends BaseController
{
    public function __construct(private ArticleRepository $repository)
    {
    }

    public function show(Request $request): \Illuminate\Contracts\View\View
    {
        $article = $this->repository->getBySlug($request->slug, app()->getLocale());

        return View::make('articles::article.show', [
            'article' => $this->resourceToArray(ArticleResource::make($article)),
        ]);
    }
}

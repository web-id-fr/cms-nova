<?php

namespace Webid\CmsNova\App\Http\Controllers;

use App\Services\ExtraElementsForPageService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Webid\CmsNova\App\Http\Resources\PageResource;
use Webid\CmsNova\App\Repositories\PageRepository;
use Webid\CmsNova\App\Services\LanguageService;
use Webid\CmsNova\App\Services\PageService;

class PageController extends BaseController
{
    protected array $extraElementsForPage;

    public function __construct(
        private readonly PageRepository $pageRepository,
        private readonly LanguageService $languageService,
        private readonly PageService $pageService
    ) {
        $this->extraElementsForPage = [];
    }

    public function index(Request $request): null|Factory|View
    {
        try {
            $slug = $this->pageRepository->getSlugForHomepage();
            $template = $this->pageRepository->getBySlugWithRelations(
                $slug->slug,
                app()->getLocale()
            );

            $data = PageResource::make($template)->resolve();

            try {
                $extraElementsService = app(ExtraElementsForPageService::class);
                $this->extraElementsForPage = $extraElementsService->getExtraElementForPage(data_get($data, 'id'));
            } catch (\Throwable $exception) {
                report($exception);
            }

            /** @var array $queryParams */
            $queryParams = $request->query();

            $meta = $this->getMetas($data, $template, $queryParams);

            return view('template', [
                'data' => $data,
                'meta' => $meta,
                'extras' => $this->extraElementsForPage,
            ]);
        } catch (\Throwable $exception) {
            report($exception);
            abort(404);
        }
    }

    public function show(Request $request): Factory|View
    {
        try {
            $path = $request->path();
            $slugs = explode('/', $path);
            $slug = end($slugs);

            $page = $this->pageRepository->getBySlugWithRelations(
                $slug,
                app()->getLocale()
            );

            $data = PageResource::make($page)->resolve();

            try {
                $extraElementsService = app(ExtraElementsForPageService::class);
                $this->extraElementsForPage = $extraElementsService->getExtraElementForPage(data_get($data, 'id'));
            } catch (\Throwable $exception) {
                report($exception);
            }

            $meta = $this->getMetas($data, $page);

            return view('template', [
                'data' => $data,
                'meta' => $meta,
                'extras' => $this->extraElementsForPage,
            ]);
        } catch (\Throwable $exception) {
            report($exception);
            abort(404);
        }
    }

    public function rootPage(): Redirector|RedirectResponse
    {
        return redirect($this->languageService->getFromBrowser());
    }

    private function getMetas(array $data, $template, $queryParams = [], array $slugs = []): array
    {
        return [
            'title' => data_get($data, 'meta_title'),
            'type' => 'realisations',
            'description' => data_get($data, 'meta_description'),
            'og_title' => data_get($data, 'opengraph_title'),
            'og_image' => data_get($data, 'opengraph_picture'),
            'og_description' => data_get($data, 'opengraph_description'),
            'indexation' => data_get($data, 'indexation'),
            'keywords' => data_get($data, 'meta_keywords'),
            'canonical' => $this->pageService->getCanonicalUrlFor($template, $queryParams, reset($slugs)),
        ];
    }
}

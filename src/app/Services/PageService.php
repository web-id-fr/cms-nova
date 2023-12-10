<?php

namespace Webid\CmsNova\App\Services;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Webid\CmsNova\App\Models\BaseTemplate;
use Webid\CmsNova\App\Repositories\PageRepository;

class PageService
{
    public function __construct(
        private PageRepository $templateRepository,
    ) {
    }

    public function getHomepageSlug(): string
    {
        try {
            $template = $this->templateRepository->getSlugForHomepage();

            if (empty($template)) {
                return '';
            }

            return $template->slug;
        } catch (ModelNotFoundException $exception) {
            return '';
        }
    }

    public function getCanonicalUrlFor(BaseTemplate $template, array $queryParams, string $language = null): string
    {
        $routeParams = [];
        $routeName = 'home';

        if (! empty($template->reference_page_id)) {
            $reference_page = $this->templateRepository->getById($template->reference_page_id);

            return url($reference_page->getFullPath());
        }

        if (! $template->isHomepage()) {
            return url($template->getFullPath());
        }

        return route($routeName, $routeParams);
    }
}

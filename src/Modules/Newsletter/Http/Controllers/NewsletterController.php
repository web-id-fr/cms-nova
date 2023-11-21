<?php

namespace Webid\CmsNova\Modules\Newsletter\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Webid\CmsNova\App\Http\Controllers\BaseController;
use Webid\CmsNova\Modules\Newsletter\Http\Requests\StoreNewsletter;
use Webid\CmsNova\Modules\Newsletter\Repositories\NewsletterRepository;

class NewsletterController extends BaseController
{
    public function __construct(private NewsletterRepository $newsletterRepository)
    {
    }

    public function store(StoreNewsletter $request): JsonResponse
    {
        $data = $request->validated();
        $data['lang'] = App::getLocale();
        $this->newsletterRepository->store($data);

        /** @var string $message */
        $message = __('template.newsletter_validation');

        return $this->jsonSuccess($message);
    }
}

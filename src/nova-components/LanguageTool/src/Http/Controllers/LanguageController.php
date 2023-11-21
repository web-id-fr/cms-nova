<?php

namespace Webid\LanguageTool\Http\Controllers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Webid\CmsNova\App\Http\Controllers\BaseController;
use Webid\LanguageTool\Http\Requests\CreateLanguageRequest;
use Webid\LanguageTool\Models\Language;
use Webid\LanguageTool\Repositories\LanguageRepository;

class LanguageController extends BaseController
{
    public function __construct(private LanguageRepository $languageRepository)
    {
    }

    public function index(): JsonResponse
    {
        return response()->json($this->languageRepository->all());
    }

    public function available(): JsonResponse
    {
        $allPossible = [];

        foreach (config('translatable.locales') as $local => $language) {
            $allPossible[] = [
                'name' => $language,
                'flag' => Language::flagsByLocal($local),
            ];
        }

        return response()->json($allPossible);
    }

    public function store(CreateLanguageRequest $request): JsonResponse
    {
        return response()->json(
            $this->languageRepository->store($request->all())
        );
    }

    public function delete(Language $language): Response|ResponseFactory
    {
        $this->languageRepository->delete($language);

        return response(null, 204);
    }
}

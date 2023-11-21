<?php

namespace Webid\CmsNova\App\Services;

use Webid\LanguageTool\Models\Language;
use Webid\LanguageTool\Repositories\LanguageRepository;

class LanguageService
{
    public function getUsedLanguage(): array
    {
        $languageRepository = new LanguageRepository(new Language());
        $languages = $languageRepository->all();
        $allPossible = [];

        $languages->each(function ($language) use (&$allPossible) {
            $allPossible[Language::getLocalByFlag($language->flag)] = $language->name;
        });

        return $allPossible;
    }

    public function getBrowserDefault(): string
    {
        /** @var string $browserLanguage */
        $browserLanguage = request()->server('HTTP_ACCEPT_LANGUAGE');

        return substr($browserLanguage, 0, 2) ?: '';
    }

    /**
     * @return bool|\Illuminate\Config\Repository|mixed|string
     */
    public function getFromBrowser()
    {
        $browserLanguage = self::getBrowserDefault();

        if (self::exists($browserLanguage)) {
            return $browserLanguage;
        }

        return config('app.locale');
    }

    public function exists(string $lang): bool
    {
        return in_array($lang, static::getUsedLanguagesSlugs());
    }

    public function getUsedLanguagesSlugs(): array
    {
        return array_keys(static::getUsedLanguage());
    }

    public function getUsedLanguagesAsRegex(): string
    {
        return implode('|', static::getUsedLanguagesSlugs());
    }

    public function getAllLanguagesAsRegex(): string
    {
        return implode('|', array_keys(config('translatable.locales') ?? []));
    }

    public function isRTL(?string $lang = null): bool
    {
        if (empty($lang)) {
            $lang = app()->getLocale();
        }

        $rtlLocales = config('translatable.rtl_locales', []);

        return in_array($lang, $rtlLocales);
    }
}

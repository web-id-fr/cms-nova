<?php

namespace Webid\CmsNova\Tests\Helpers\Traits;

use Webid\LanguageTool\Models\Language;

trait LanguageCreator
{
    public function createLanguage(array $params = []): Language
    {
        return Language::factory($params)->create();
    }
}

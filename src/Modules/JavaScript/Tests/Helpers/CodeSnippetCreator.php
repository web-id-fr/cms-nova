<?php

namespace Webid\CmsNova\Modules\JavaScript\Tests\Helpers;

use Webid\CmsNova\Modules\JavaScript\Models\CodeSnippet;

trait CodeSnippetCreator
{
    private function createCodeSnippet(array $parameters = []): CodeSnippet
    {
        return CodeSnippet::factory($parameters)->create();
    }
}

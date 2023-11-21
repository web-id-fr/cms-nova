<?php

namespace Webid\CmsNova\Modules\JavaScript\Tests\Feature;

use Illuminate\Database\Eloquent\Model;
use Webid\CmsNova\Modules\JavaScript\Tests\CodeSnippetTestCase;
use Webid\CmsNova\Modules\JavaScript\Tests\Helpers\CodeSnippetCreator;
use Webid\CmsNova\Tests\Helpers\Traits\TestsNovaResource;

/**
 * @internal
 */
class CodeSnippetTest extends CodeSnippetTestCase
{
    use CodeSnippetCreator;
    use TestsNovaResource;

    protected function getResourceName(): string
    {
        return 'code-snippets';
    }

    protected function getModel(): Model
    {
        return $this->createCodeSnippet();
    }
}

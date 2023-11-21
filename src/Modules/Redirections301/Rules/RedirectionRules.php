<?php

namespace Webid\CmsNova\Modules\Redirections301\Rules;

use Illuminate\Validation\Rule;
use Webid\CmsNova\App\Rules\IsUrlPath;
use Webid\CmsNova\Modules\Redirections301\Models\Redirection;

class RedirectionRules
{
    public static function sourceUrlRules(int $modelIdToIgnore = null): array
    {
        return [
            'required',
            Rule::unique((new Redirection())->getTable(), 'source_url')->ignore($modelIdToIgnore),
            new IsUrlPath(),
        ];
    }

    public static function destinationUrlRules(): array
    {
        return [
            'required',
            new IsUrlPath(),
        ];
    }
}

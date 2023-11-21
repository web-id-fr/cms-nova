<?php

namespace Webid\CmsNova\App\Services\Traits;

trait DirectiveHasOptions
{
    protected function extractOptions(string $optionsString): array
    {
        try {
            // todo : ici faire autrement qu'avec "eval" ...
            $array = eval("return {$optionsString};");

            if (! is_array($array)) {
                $array = [];
            }
        } catch (\Throwable $throwable) {
            info($throwable->getMessage());

            $array = [];
        }

        return $array;
    }
}

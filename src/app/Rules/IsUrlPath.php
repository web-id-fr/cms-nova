<?php

namespace Webid\CmsNova\App\Rules;

use Illuminate\Contracts\Validation\Rule;

class IsUrlPath implements Rule
{
    /**
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return boolval(preg_match('/^(\/|(\/[^\/]+)+\/?)$/i', $value));
    }

    public function message(): null|array|string
    {
        return __('rules.is_url_path');
    }
}

<?php

namespace Webid\CmsNova\App\Rules;

use Illuminate\Contracts\Validation\Rule;

class TranslatableSlug implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $pass = true;
        foreach ($value as $val) {
            if (! preg_match('/^[\pL\pM\pN_-]+$/u', $val)) {
                $pass = false;
            }
        }

        return $pass;
    }

    public function message(): null|array|string
    {
        return __('validation.alpha_dash');
    }
}

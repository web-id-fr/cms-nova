<?php

namespace Webid\CmsNova\App\Rules;

use Illuminate\Contracts\Validation\Rule;

class TranslatableMax implements Rule
{
    public int $nbCharacters;

    public function __construct(int $nbCharacters)
    {
        $this->nbCharacters = $nbCharacters;
    }

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
            if (strlen($val) > $this->nbCharacters) {
                $pass = false;
            }
        }

        return $pass;
    }

    public function message(): string
    {
        return 'The :attribute field must be under ' . $this->nbCharacters . ' characters.';
    }
}

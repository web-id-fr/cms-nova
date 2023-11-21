<?php

namespace Webid\CmsNova\Modules\Newsletter\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNewsletter extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email:filter|unique:newsletters,email',
        ];
    }
}

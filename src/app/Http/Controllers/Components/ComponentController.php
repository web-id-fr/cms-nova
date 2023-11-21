<?php

namespace Webid\CmsNova\App\Http\Controllers\Components;

use Webid\CmsNova\App\Http\Controllers\BaseController;

class ComponentController extends BaseController
{
    /**
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    public function index()
    {
        $components = config('components');

        return array_filter($components, function ($component) {
            return ! array_key_exists('display_on_components_list', $component)
                || false !== $component['display_on_components_list'];
        });
    }
}

<?php

namespace Webid\CmsNova\Modules\Form\Http\Controllers;

use Webid\CmsNova\App\Http\Controllers\BaseController;

class CsrfController extends BaseController
{
    public function index(): string
    {
        return csrf_token();
    }
}

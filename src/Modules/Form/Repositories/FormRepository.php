<?php

namespace Webid\CmsNova\Modules\Form\Repositories;

use Webid\CmsNova\Modules\Form\Models\Form;

class FormRepository
{
    public function __construct(private Form $model)
    {
    }

    /**
     * @return mixed
     */
    public function getPublishedForms()
    {
        return $this->model
            ->where('status', Form::_STATUS_PUBLISHED)
            ->with([
                'fields',
                'titleFields',
                'recipients',
                'services',
                'related.formables',
            ])->get()
        ;
    }

    /**
     * @return mixed
     */
    public function find(int $id)
    {
        return $this->model
            ->with([
                'fields',
                'titleFields',
                'recipients',
                'services',
                'related.formables',
            ])
            ->find($id)
        ;
    }
}

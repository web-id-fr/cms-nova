<?php

namespace Webid\LanguageTool\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Webid\LanguageTool\Models\Language;

class LanguageRepository
{
    public function __construct(private Language $model)
    {
    }

    public function store(array $data): Model
    {
        return $this->model->create($data);
    }

    public function all(): Collection
    {
        return $this->model
            ->all()
        ;
    }

    public function delete(Model $language): ?bool
    {
        return $language->delete();
    }
}

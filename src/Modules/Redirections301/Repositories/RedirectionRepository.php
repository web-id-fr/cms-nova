<?php

namespace Webid\CmsNova\Modules\Redirections301\Repositories;

use Webid\CmsNova\Modules\Redirections301\Models\Redirection;

class RedirectionRepository
{
    public function __construct(private Redirection $model)
    {
    }

    public function findBySourcePath(string $path): ?Redirection
    {
        return $this->model
            ->where('source_url', 'REGEXP', "^/{$path}/?$")
            ->first()
        ;
    }

    public function create(string $from, string $to): Redirection
    {
        return $this->model->create([
            'source_url' => $from,
            'destination_url' => $to,
        ]);
    }
}

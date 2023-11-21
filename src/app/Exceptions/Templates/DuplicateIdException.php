<?php

namespace Webid\CmsNova\App\Exceptions\Templates;

class DuplicateIdException extends \Exception
{
    public function __construct(
        array $ids,
        string $message = '',
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        $message = empty($message) ? 'The following IDs are duplicates : ' . implode(', ', $ids) : $message;

        parent::__construct($message, $code, $previous);
    }
}

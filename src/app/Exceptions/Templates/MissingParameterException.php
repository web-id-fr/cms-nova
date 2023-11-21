<?php

namespace Webid\CmsNova\App\Exceptions\Templates;

class MissingParameterException extends \Exception
{
    public function __construct(
        string $message = 'A parameter is missing',
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}

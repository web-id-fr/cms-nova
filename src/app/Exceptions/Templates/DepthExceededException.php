<?php

namespace Webid\CmsNova\App\Exceptions\Templates;

class DepthExceededException extends \Exception
{
    public function __construct(
        $message = 'The maximal allowed depth was reached while scanning the templates.',
        $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}

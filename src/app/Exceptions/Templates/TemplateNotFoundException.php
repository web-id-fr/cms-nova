<?php

namespace Webid\CmsNova\App\Exceptions\Templates;

class TemplateNotFoundException extends \Exception
{
    public string $templatePath = '';

    public function __construct(
        string $templatePath,
        string $message = '',
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        $this->templatePath = $templatePath;

        $message = empty($message) ? "The template {$this}->{$templatePath} was not found." : $message;

        parent::__construct($message, $code, $previous);
    }
}

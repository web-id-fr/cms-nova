<?php

namespace Webid\CmsNova\App\Services\MenuBladeDirective;

use Webid\CmsNova\App\Exceptions\Templates\MissingParameterException;
use Webid\CmsNova\App\Services\Traits\DirectiveHasOptions;

class Menu
{
    use DirectiveHasOptions;

    public string $originalExpression;

    public string $menuID;

    public string $label;

    public array $options = [];

    /**
     * @throws MissingParameterException
     */
    public function __construct(string $zoneParams)
    {
        $this->originalExpression = $zoneParams;

        $zoneParams = explode(',', $zoneParams, 3);

        $options = $this->extractOptions($zoneParams[2] ?? '');

        if (empty($zoneParams[0]) || ! is_string($zoneParams[0])) {
            throw new MissingParameterException('The @menu first attribute is missing or invalid.');
        }
        if (isset($zoneParams[1]) && ! is_string($zoneParams[1])) {
            throw new \InvalidArgumentException('The @menu second attribute is invalid.');
        }

        $this->menuID = trim(data_get($zoneParams, 0, ''), ' "\'');
        $this->label = trim(data_get($zoneParams, 1, ucwords(str_unslug($this->menuID))), ' "\'');
        $this->options = $options;
    }
}

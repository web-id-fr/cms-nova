<?php
/*
|--------------------------------------------------------------------------
| Components config
|--------------------------------------------------------------------------
|
| Use the following schema to store components :
|
| 'text_image' => [
|     'from_config_file' => base_path('modules/cms-components/TextImageComponent/config.php'),
|     'display_on_components_list' => true,
|     'image' => '/cms/images/components/text_component.png',
| ]
*/

use Webid\CmsNova\Modules\Components\TextComponent\Models\TextComponent;
use Webid\CmsNova\Modules\Components\TextComponent\Nova\TextNovaComponent;
use Webid\CmsNova\Modules\Components\TextComponent\Resources\TextResource;

return [
    'text' => [
        'title' => 'Text component',
        'model' => TextComponent::class,
        'resource' => TextResource::class,
        'nova_component' => TextNovaComponent::class,
        'image' => '/cms/images/components/text_component.png',
        'view' => 'components/text',
        'display_on_components_list' => true,
        'nova' => '/nova/resources/text-nova-components',
    ],
];

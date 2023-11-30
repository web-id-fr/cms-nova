<?php

use Webid\CmsNova\App\Http\Resources\Components\TextComponentResource;
use Webid\CmsNova\App\Models\Components\TextComponent;

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

return [
    'text' => [
        'title' => 'Text component',
        'model' => TextComponent::class,
        'resource' => TextComponentResource::class,
        'nova_component' => \App\Nova\TextComponent::class,
        'image' => '/cms/images/components/text_component.png',
        'view' => 'components/text',
        'display_on_components_list' => true,
        'nova' => '/nova/resources/text-nova-components',
    ],
];

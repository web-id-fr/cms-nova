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
| ComponentModel::class => [
|   'title" => 'Title component",
|   'image' => 'PATH_TO_COMPONENT_IMAGE', // /images/components/component.png
|   'resource => CompenentResource::class,
|   'view' => 'PATH_TO_COMPONENT_VIEW, // components/component
|   'nova' => 'URL_TO_ACCES_RESOURCE_NOVA', // /nova/resources/component
|   'display_on_components_list' => false // optional
| ]
*/

return [
    TextComponent::class => [
        'title' => 'Text component',
        'image' => '/cms/images/components/text_component.png',
        'resource' => TextComponentResource::class,
        'view' => 'components/text',
        'display_on_components_list' => true,
    ],
];

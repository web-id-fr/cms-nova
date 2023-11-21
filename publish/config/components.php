<?php

use Webid\CmsNova\App\Http\Resources\Components\BreadcrumbComponentResource;
use Webid\CmsNova\App\Models\Components\BreadcrumbComponent;

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
    BreadcrumbComponent::class => [
        'title' => 'Breadcrumb component',
        'image' => '/cms/images/components/breadcrumb_component.png',
        'resource' => BreadcrumbComponentResource::class,
        'view' => 'components/breadcrumb',
        'display_on_components_list' => false,
    ],
];

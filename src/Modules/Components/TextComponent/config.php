<?php

use Webid\CmsTextImageComponent\Models\TextImageComponent;
use Webid\CmsTextImageComponent\Nova\TextImageNovaComponent;
use Webid\CmsTextImageComponent\Resources\TextImageResource;

return [
    'title' => __('Text / Image'),
    'version' => '1.0.0',
    'root_dir' => __DIR__,
    'model' => TextImageComponent::class,
    'resource' => TextImageResource::class,
    'nova_component' => TextImageNovaComponent::class,
    'nova' => '/nova/resources/text-image-nova-components',
    'migrations_dir' => __DIR__ . '/migrations',
    'image' => 'text_image_component_screenshot.png'
];

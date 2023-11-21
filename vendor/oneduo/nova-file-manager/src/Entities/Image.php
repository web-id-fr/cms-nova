<?php

declare(strict_types=1);

namespace Oneduo\NovaFileManager\Entities;

use Oneduo\NovaFileManager\Filesystem\Metadata\Factory;

class Image extends Entity
{
    public function meta(): array
    {
        $data = Factory::build($this->manager->filesystem())?->analyze($this->path);

        return [
            'type' => 'image',
            'width' => data_get($data, 'video.resolution_x'),
            'height' => data_get($data, 'video.resolution_y'),
            'aspectRatio' => data_get($data, 'video.pixel_aspect_ratio'),
        ];
    }
}

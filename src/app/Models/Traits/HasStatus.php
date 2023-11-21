<?php

namespace Webid\CmsNova\App\Models\Traits;

trait HasStatus
{
    public static function statusLabels(): array
    {
        return [
            self::_STATUS_PUBLISHED => __('Published'),
            self::_STATUS_DRAFT => __('Draft'),
        ];
    }

    public function isPublished(): bool
    {
        return self::_STATUS_PUBLISHED == $this->status;
    }
}

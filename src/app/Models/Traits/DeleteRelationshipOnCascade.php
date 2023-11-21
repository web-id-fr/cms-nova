<?php

namespace Webid\CmsNova\App\Models\Traits;

use Illuminate\Support\Facades\DB;

trait DeleteRelationshipOnCascade
{
    protected static function booted()
    {
        static::deleted(function ($component) {
            try {
                DB::table('components')
                    ->where('component_id', '=', $component->getKey())
                    ->where('component_type', '=', get_class($component))
                    ->delete()
                ;
            } catch (\Throwable $exception) {
                report($exception);
            }
        });
    }
}

<?php

namespace Webid\CmsNova\App\Services;

class DynamicResource
{
    private static array $topLevelResources = [];
    private static array $templateModuleGroupResources = [];
    private static array $singleModuleResources = [];

    public static function pushTopLevelResource(array $resource): void
    {
        array_push(self::$topLevelResources, $resource);
    }

    public static function getTopLevelResources(): array
    {
        return self::$topLevelResources;
    }

    public static function pushTemplateModuleGroupResource(array $resource): void
    {
        array_push(self::$templateModuleGroupResources, $resource);
    }

    public static function getTemplateModuleGroupResources(): array
    {
        return self::$templateModuleGroupResources;
    }

    public static function pushSingleModuleResource(array $resource): void
    {
        array_push(self::$singleModuleResources, $resource);
    }

    public static function getSingleModuleResources(): array
    {
        return self::$singleModuleResources;
    }
}

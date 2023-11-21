<?php

declare(strict_types=1);

use Arkitect\ClassSet;
use Arkitect\CLI\Config;
use Arkitect\Expression\ForClasses\HaveNameMatching;
use Arkitect\Expression\ForClasses\IsNotTrait;
use Arkitect\Expression\ForClasses\NotHaveNameMatching;
use Arkitect\Expression\ForClasses\ResideInOneOfTheseNamespaces;
use Arkitect\Rules\Rule;

return static function (Config $config): void {
    /*
    |--------------------------------------------------------------------------
    | Register paths to analyse
    |--------------------------------------------------------------------------
    */

    $mvcClassSet = ClassSet::fromDir(__DIR__.'/')
        ->excludePath('bin')
        ->excludePath('bootstrap')
        ->excludePath('*/node_modules')
        ->excludePath('public')
        ->excludePath('resources')
        ->excludePath('sail')
        ->excludePath('storage')
        ->excludePath('stubs')
        ->excludePath('vendor')
    ;

    $rules = [];

    /*
    |--------------------------------------------------------------------------
    | Register naming convention to be followed rules
    |--------------------------------------------------------------------------
    */

    $namingRulesShouldMatch = [
        '*\Http\Controllers' => '*Controller',
        '*\Http\Requests' => '*Request',
        '*\Policies' => '*Policy',
        '*\Repositories' => '*Repository',
        '*\Providers' => '*ServiceProvider',
    ];

    foreach ($namingRulesShouldMatch as $namespace => $match) {
        $rules[] = Rule::allClasses()->that(new IsNotTrait())
            ->andThat(new ResideInOneOfTheseNamespaces($namespace))
            ->should(new HaveNameMatching($match))
            ->because('we want uniform naming')
        ;
    }

    /*
    |--------------------------------------------------------------------------
    | Register naming convention to be avoided rules
    |--------------------------------------------------------------------------
    */

    $namingRulesShouldNotMatch = [
        '*\Http\Middlewares' => '*Middleware',
        '*\Services' => '*Service',
    ];

    foreach ($namingRulesShouldNotMatch as $namespace => $match) {
        $rules[] = Rule::allClasses()->that(new IsNotTrait())
            ->andThat(new ResideInOneOfTheseNamespaces($namespace))
            ->should(new NotHaveNameMatching($match))
            ->because('we want uniform naming')
        ;
    }
};

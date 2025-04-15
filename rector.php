<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\Class_\InlineConstructorDefaultToPropertyRector;
use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\SetList;
use Rector\TypeDeclaration\Rector\Property\TypedPropertyFromStrictConstructorRector;
use RectorLaravel\Set\LaravelLevelSetList;
use RectorLaravel\Set\LaravelSetList;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/app',
        __DIR__ . '/bootstrap',
        __DIR__ . '/config',
        __DIR__ . '/resources',
        __DIR__ . '/routes',
        __DIR__ . '/tests',
    ])
    ->withSkip([
        __DIR__ . '/bootstrap/cache/*',
        // Skip Laravel-generated views
        // __DIR__ . '/resources/views/*',
        \RectorLaravel\Rector\ClassMethod\ScopeNamedClassMethodToScopeAttributedClassMethodRector::class,

    ])
    // uncomment to reach your current PHP version
    ->withPhpSets()
    ->withSets([

        LaravelLevelSetList::UP_TO_LARAVEL_120,
        LaravelSetList::LARAVEL_CODE_QUALITY,

        SetList::NAMING,
        SetList::CODING_STYLE,        // Changes coding style
        SetList::DEAD_CODE,             // Removes unused code
        SetList::EARLY_RETURN,          // Converts nested conditions to early returns
        SetList::TYPE_DECLARATION,
    ])
    ->withTypeCoverageLevel(5)
    ->withDeadCodeLevel(5)
    ->withCodeQualityLevel(5)
    ->withRules([
        InlineConstructorDefaultToPropertyRector::class,
        TypedPropertyFromStrictConstructorRector::class,
    ])
    // Parallel processing for faster execution
    ->withParallel();;

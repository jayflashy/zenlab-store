<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\Class_\InlineConstructorDefaultToPropertyRector;
use Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector;
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
        EncapsedStringsToSprintfRector::class,
        \RectorLaravel\Rector\ClassMethod\ScopeNamedClassMethodToScopeAttributedClassMethodRector::class,

    ])
    // uncomment to reach your current PHP version
    ->withPhpSets()
    ->withSets([
        LaravelSetList::LARAVEL_120,
        SetList::CODING_STYLE,           // Removes unused code
        SetList::EARLY_RETURN,
        SetList::DEAD_CODE,
        SetList::TYPE_DECLARATION,
        SetList::PRIVATIZATION,

    ])
    ->withRules([
        \Rector\CodeQuality\Rector\If_\SimplifyIfElseToTernaryRector::class,
        \Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector::class,
    ])
    ->withImportNames()
    // Parallel processing for faster execution
    ->withParallel();;

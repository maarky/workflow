<?php
declare(strict_types=1);

namespace maarky\Workflow\Task\Arr\FlatMap;

use maarky\Monad\SingleContainer;
use maarky\Workflow\Type\Numeric\Workflow as NumericWorkflow;
use maarky\Workflow\Workflow;

function array_product(string $class = null): callable
{
    $class = $class ?: NumericWorkflow::class;
    return function($array) use($class): SingleContainer {
        $array = \array_product($array);
        return $class::create($array);
    };

}

function array_rand(string $class = null): callable
{
    $class = $class ?: Workflow::class;
    return function($array) use($class): SingleContainer {
        $key = \array_rand($array);
        return $class::create($key);
    };
}

function array_rand_value(string $class = null): callable
{$class = $class ?: Workflow::class;
    return function($array) use($class): SingleContainer {
        $key = \array_rand($array);
        $item = $array[$key];
        return $class::create($item);
    };
}

function array_reduce(callable $callable, $initial = null, string $class = null): callable
{
    $class = $class ?: Workflow::class;
    return function($array) use($callable, $initial, $class): SingleContainer {
        $array = \array_reduce($array, $callable, $initial);
        return $class::create($array);
    };
}

/**
 * Get first element from array
 */
function head(string $class = null): callable
{
    $class = $class ?: Workflow::class;
    return function($array) use($class): SingleContainer {
        $item = \array_shift($array);
        return $class::create($item);
    };
}

/**
 * Get last element from array
 */
function last(string $class = null): callable
{
    $class = $class ?: Workflow::class;
    return function($array) use($class): SingleContainer {
        $item = array_pop($array);
        return $class::create($item);
    };
}
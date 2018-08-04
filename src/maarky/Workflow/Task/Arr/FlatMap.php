<?php
declare(strict_types=1);

namespace maarky\Workflow\Task\Arr\FlatMap;

use maarky\Monad\SingleContainer;
use maarky\Workflow\Type\Numeric\Workflow as NumericWorkflow;
use maarky\Workflow\Type\String\Workflow as StringWorkflow;
use maarky\Workflow\Type\Int\Workflow as IntWorkflow;
use maarky\Workflow\Workflow;
use maarky\Workflow\Task\Utility;

function array_pop(string $class = null)
{
    $class = $class ?: Workflow::class;
    return function($array) use($class): SingleContainer {
        $item = \array_pop($array);
        return $class::create($item);
    };
}

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
    return function($array) use($class): SingleContainer {
        $key = \array_rand($array);
        if(!$class && is_int($key)) {
            $class = IntWorkflow::class;
        } elseif (!$class) {
            $class = StringWorkflow::class;
        }
        return $class::create($key);
    };
}

function array_rand_value(string $class = null): callable
{
    $class = $class ?: Workflow::class;
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
function array_shift(string $class = null): callable
{
    $class = $class ?: Workflow::class;
    return function($array) use($class): SingleContainer {
        $item = \array_shift($array);
        return $class::create($item);
    };
}

function array_search($needle, bool $strict = false, string $class = null): callable
{
    return function($array) use($needle, $strict, $class): SingleContainer {
        $key = \array_search($needle, $array, $strict);
        if(!$class && is_int($key)) {
            $class = IntWorkflow::class;
        } elseif (!$class) {
            $class = StringWorkflow::class;
        }
        return $class::create($key);
    };
}

function array_sum(string $class = null)
{
    $class = $class ?: NumericWorkflow::class;
    return function ($array) use ($class)
    {
        $result = \array_sum($array);
        return $class::create($result);
    };
}

function count()
{
    return function ($array) {
        $count = \count($array);
        return IntWorkflow::create($count);
    };
}

function implode(string $glue, string $class = null)
{
    $class = $class ?: StringWorkflow::class;
    return function ($array) use ($glue, $class)
    {
        $result = \implode($glue, $array);
        return $class::create($result);
    };
}
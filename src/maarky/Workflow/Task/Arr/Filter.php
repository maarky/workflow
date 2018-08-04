<?php
declare(strict_types=1);

namespace maarky\Workflow\Task\Arr\Filter;

use maarky\Workflow\Task\Utility;

function array_key_exists($key): callable
{
    $callback = function ($array) use($key) {
        return \array_key_exists($key, $array);
    };
    return Utility::doBooleanCallback($callback);
}

function array_walk_recursive(callable $callback, $userdata = null)
{
    $callback = function ($array) use($callback, $userdata) {
        return \array_walk_recursive($array, $callback, $userdata);
    };
    return Utility::doBooleanCallback($callback);
}

function array_walk(callable $callback, $userdata = null)
{
    $callback = function ($array) use($callback, $userdata) {
        return \array_walk($array, $callback, $userdata);
    };
    return Utility::doBooleanCallback($callback);
}

function count()
{
    $callback = function ($array) {
        $count = \count($array);
        return $count > 0;
    };
    return Utility::doBooleanCallback($callback);
}

function in_array($needle, bool $strict = false)
{
    $callback = function ($array) use($needle, $strict) {
        return \in_array($needle, $array, $strict);
    };
    return Utility::doBooleanCallback($callback);
}
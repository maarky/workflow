<?php
declare(strict_types=1);

namespace maarky\Workflow\Task\Arr\Map\Sort;

use maarky\Workflow\Task\Utility;

function array_reverse(bool $preserveKeys = false)
{
    $callback = function($array) use($preserveKeys) {
        return \array_reverse($array, $preserveKeys);
    };
    return Utility::doArrayCallback($callback);
}

function arsort(int $sortFlags = SORT_REGULAR)
{
    $callback = function($array) use($sortFlags) {
        \arsort($array, $sortFlags);
        return $array;
    };
    return Utility::doArrayCallback($callback);
}

function asort(int $sortFlags = SORT_REGULAR)
{
    $callback = function($array) use($sortFlags) {
        \asort($array, $sortFlags);
        return $array;
    };
    return Utility::doArrayCallback($callback);
}

function krsort(int $sortFlags = SORT_REGULAR)
{
    $callback = function($array) use($sortFlags) {
        \krsort($array, $sortFlags);
        return $array;
    };
    return Utility::doArrayCallback($callback);
}

function ksort(int $sortFlags = SORT_REGULAR)
{
    $callback = function($array) use($sortFlags) {
        \ksort($array, $sortFlags);
        return $array;
    };
    return Utility::doArrayCallback($callback);
}

function natcasesort()
{
    $callback = function($array) {
        \natcasesort($array);
        return $array;
    };
    return Utility::doArrayCallback($callback);
}

function natsort()
{
    $callback = function($array) {
        \natsort($array);
        return $array;
    };
    return Utility::doArrayCallback($callback);
}

function rsort(int $sortFlags = SORT_REGULAR)
{
    $callback = function($array) use($sortFlags) {
        \rsort($array, $sortFlags);
        return $array;
    };
    return Utility::doArrayCallback($callback);
}

function shuffle()
{
    $callback = function($array) {
        \shuffle($array);
        return $array;
    };
    return Utility::doArrayCallback($callback);
}

function sort(int $sortFlags = SORT_REGULAR)
{
    $callback = function($array) use($sortFlags) {
        \sort($array, $sortFlags);
        return $array;
    };
    return Utility::doArrayCallback($callback);
}

function uasort(callable $sortFunc)
{
    $callback = function($array) use($sortFunc) {
        \uasort($array, $sortFunc);
        return $array;
    };
    return Utility::doArrayCallback($callback);
}

function uksort(callable $sortFunc)
{
    $callback = function($array) use($sortFunc) {
        \uksort($array, $sortFunc);
        return $array;
    };
    return Utility::doArrayCallback($callback);
}

function usort(callable $sortFunc)
{
    $callback = function($array) use($sortFunc) {
        \usort($array, $sortFunc);
        return $array;
    };
    return Utility::doArrayCallback($callback);
}
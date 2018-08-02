<?php
declare(strict_types=1);

namespace maarky\Workflow\Task\Arr\Map;

use maarky\Workflow\Task\Utility;

function array_diff(array ...$arrays): callable
{
    $callback = function ($array) use($arrays): array {
        return \array_diff($array, ...$arrays);
    };
    return Utility::doArrayCallback($callback);
}

function array_diff_assoc(array ...$arrays): callable
{
    $callback = function ($array) use($arrays) {
        return \array_diff_assoc($array, ...$arrays);
    };
    return Utility::doArrayCallback($callback);
}

function array_diff_key(array ...$arrays): callable
{
    $callback = function ($array) use($arrays) {
        return \array_diff_key($array, ...$arrays);
    };
    return Utility::doArrayCallback($callback);
}

function array_diff_uassoc(callable $callback, array ...$arrays): callable
{
    $arrays[] = $callback;
    $callback = function ($array) use($arrays) {
        return \array_diff_uassoc($array, ...$arrays);
    };
    return Utility::doArrayCallback($callback);
}

function array_diff_ukey(callable $callback, array ...$arrays): callable
{
    $arrays[] = $callback;
    $callback = function ($array) use($arrays) {
        return \array_diff_ukey($array, ...$arrays);
    };
    return Utility::doArrayCallback($callback);
}

function array_change_key_case(int $case = CASE_LOWER): callable
{
    $callback = function ($array) use($case) {
        return \array_change_key_case($array, $case);
    };
    return Utility::doArrayCallback($callback);
}

function array_chunk(int $size, bool $preserve_keys = false): callable
{
    $callback = function ($array) use($size, $preserve_keys) {
        return \array_chunk($array, $size, $preserve_keys);
    };
    return Utility::doArrayCallback($callback);
}

function array_column($columnKey, $indexKey = null): callable
{
    $callback = function ($array) use ($columnKey, $indexKey) {
        return \array_column($array, $columnKey, $indexKey);
    };
    return Utility::doArrayCallback($callback);
}

function array_count_values(): callable
{
    $callback = function($array) {
        return \array_count_values($array);
    };
    return Utility::doArrayCallback($callback);
}

function array_filter(callable $filter, int $flag = 0): callable
{
    $callback = function($array) use($filter, $flag) {
        return \array_filter($array, $filter, $flag);
    };
    return Utility::doArrayCallback($callback);
}

function array_flip(): callable
{
    $callback = function($array) {
        return \array_flip($array);
    };
    return Utility::doArrayCallback($callback);
}

function array_fill_keys($value): callable
{
    $callback = function($array) use($value) {
        return \array_fill_keys($array, $value);
    };
    return Utility::doArrayCallback($callback);
}

function array_keys($search = null, bool $strict = false): callable
{
    $callback = function($array) use($search, $strict) {
        return $search ? \array_keys($array, $search, $strict) : \array_keys($array);
    };
    return Utility::doArrayCallback($callback);
}

function array_map(callable $callback, array ...$arrays): callable
{
    $callback = function($array) use($callback, $arrays) {
        return \array_map($callback, $array, ...$arrays);
    };
    return Utility::doArrayCallback($callback);
}

function array_merge_recursive(array ...$arrays): callable
{
    $callback = function($array) use($arrays) {
        return \array_merge_recursive($array, ...$arrays);
    };
    return Utility::doArrayCallback($callback);
}

function array_merge(array ...$arrays): callable
{
    $callback = function($array) use($arrays) {
        return \array_merge($array, ...$arrays);
    };
    return Utility::doArrayCallback($callback);
}

function array_pad(int $size, $value): callable
{
    $callback = function($array) use($size, $value) {
        return \array_pad($array, $size, $value);
    };
    return Utility::doArrayCallback($callback);
}

/**
 * Get array with first item removed
 */
function tail(): callable
{
    $callback = function($array) {
        return \array_slice($array, 1, null, true);
    };
    return Utility::doArrayCallback($callback);
}

/**
 * Get array with last item removed
 */
function init(): callable
{
    $callback = function($array) {
        return array_slice($array, 0, -1, true);
    };
    return Utility::doArrayCallback($callback);
}

function array_push($value): callable
{
    $callback = function($array) use($value) {
        \array_push($array, $value);
        return $array;
    };
    return Utility::doArrayCallback($callback);
}

function array_rand($num = 1): callable
{
    $callback = function($array) use($num) {
        return (array) \array_rand($array, $num);
    };
    return Utility::doArrayCallback($callback);
}

function array_rand_values($num = 1): callable
{
    $callback = function($array) use($num) {
        $result = (array) \array_rand($array, $num);
        $combined = \array_combine($result, \array_pad([], $num, 1));
        $intersection = \array_intersect_key($array, $combined);
        return $intersection;
    };
    return Utility::doArrayCallback($callback);
}

function array_replace(...$arrays): callable
{
    $callback = function($array) use($arrays) {
        return \array_replace($array, ...$arrays);
    };
    return Utility::doArrayCallback($callback);
}

function array_replace_recursive(...$arrays): callable
{
    $callback = function($array) use($arrays) {
        return \array_replace_recursive($array, ...$arrays);
    };
    return Utility::doArrayCallback($callback);
}

function array_intersect(array ...$arrays)
{
    $callback = function ($array) use($arrays) {
        return \array_intersect($array, ...$arrays);
    };
    return Utility::doArrayCallback($callback);
}

function array_intersect_assoc(array ...$arrays)
{
    $callback = function ($array) use($arrays) {
        return \array_intersect_assoc($array, ...$arrays);
    };
    return Utility::doArrayCallback($callback);
}

function array_intersect_key(array ...$arrays)
{
    $callback = function ($array) use($arrays) {
        return \array_intersect_key($array, ...$arrays);
    };
    return Utility::doArrayCallback($callback);
}

function array_intersect_uassoc(callable $callback, array ...$arrays)
{
    $arrays[] = $callback;
    $callback = function ($array) use($arrays) {
        return \array_intersect_uassoc($array, ...$arrays);
    };
    return Utility::doArrayCallback($callback);
}

function array_intersect_ukey(callable $callback, array ...$arrays)
{
    $arrays[] = $callback;
    $callback = function ($array) use($arrays) {
        return \array_intersect_ukey($array, ...$arrays);
    };
    return Utility::doArrayCallback($callback);
}

function array_udiff(callable $callback, array ...$arrays)
{
    $arrays[] = $callback;
    $callback = function ($array) use($arrays) {
        return \array_udiff($array, ...$arrays);
    };
    return Utility::doArrayCallback($callback);
}

function array_udiff_assoc(callable $callback, array ...$arrays)
{
    $arrays[] = $callback;
    $callback = function ($array) use($arrays) {
        return \array_udiff_assoc($array, ...$arrays);
    };
    return Utility::doArrayCallback($callback);
}

function array_udiff_uassoc($valCompare, $keyCompare, array ...$arrays)
{
    $arrays[] = $valCompare;
    $arrays[] = $keyCompare;
    $callback = function ($array) use($arrays) {
        return \array_udiff_uassoc($array, ...$arrays);
    };
    return Utility::doArrayCallback($callback);
}

function array_uintersect(callable $callback, array ...$arrays)
{
    $arrays[] = $callback;
    $callback = function ($array) use($arrays) {
        return \array_uintersect($array, ...$arrays);
    };
    return Utility::doArrayCallback($callback);
}

function array_uintersect_assoc(callable $callback, array ...$arrays)
{
    $arrays[] = $callback;
    $callback = function ($array) use($arrays) {
        return \array_uintersect_assoc($array, ...$arrays);
    };
    return Utility::doArrayCallback($callback);
}

function array_uintersect_uassoc($valCompare, $keyCompare, array ...$arrays)
{
    $arrays[] = $valCompare;
    $arrays[] = $keyCompare;
    $callback = function ($array) use($arrays) {
        return \array_uintersect_uassoc($array, ...$arrays);
    };
    return Utility::doArrayCallback($callback);
}
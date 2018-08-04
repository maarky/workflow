<?php
declare(strict_types=1);

namespace maarky\Workflow\Task\Arr\Map;

use maarky\Workflow\Task\Utility;

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

function array_combine_values(array $values): callable
{
    $callback = function ($array) use ($values) {
        return \array_combine($array, $values);
    };
    return Utility::doArrayCallback($callback);
}

function array_combine_keys(array $keys): callable
{
    $callback = function ($array) use ($keys) {
        return \array_combine($keys, $array);
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

function array_fill_keys($value): callable
{
    $callback = function($array) use($value) {
        return \array_fill_keys($array, $value);
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

function array_pop(): callable
{
    $callback = function($array) {
        \array_pop($array);
        return $array;
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

function array_rand(int $num = 1): callable
{
    $callback = function($array) use($num) {
        return (array) \array_rand($array, $num);
    };
    return Utility::doArrayCallback($callback);
}

function array_rand_values(int $num = 1): callable
{
    $callback = function($array) use($num) {
        $result = (array) \array_rand($array, $num);
        $combined = \array_combine($result, \array_pad([], $num, 1));
        $intersection = \array_intersect_key($array, $combined);
        return $intersection;
    };
    return Utility::doArrayCallback($callback);
}

function array_replace(array ...$arrays): callable
{
    $callback = function($array) use($arrays) {
        return \array_replace($array, ...$arrays);
    };
    return Utility::doArrayCallback($callback);
}

function array_replace_recursive(array ...$arrays): callable
{
    $callback = function($array) use($arrays) {
        return \array_replace_recursive($array, ...$arrays);
    };
    return Utility::doArrayCallback($callback);
}

function array_shift(): callable
{
    return function($array) {
        \array_shift($array);
        return $array;
    };
}

function array_slice(int $offset, int $length = null, bool $preserveKeys = false): callable
{
    $callback = function ($array) use($offset, $length, $preserveKeys) {
        return \array_slice($array, $offset, $length, $preserveKeys);
    };
    return Utility::doArrayCallback($callback);
}

function array_unique(int $sortFlags = SORT_STRING)
{
    $callback = function ($array) use($sortFlags) {
        return \array_unique($array, $sortFlags);
    };
    return Utility::doArrayCallback($callback);
}

function array_unshift(...$values)
{
    $callback = function ($array) use($values) {
        \array_unshift($array, ...$values);
        return $array;
    };
    return Utility::doArrayCallback($callback);
}

function array_values()
{
    $callback = function ($array) {
        return \array_values($array);
    };
    return Utility::doArrayCallback($callback);
}

function array_walk(callable $callback, $userdata = null)
{
    $callback = function ($array) use($callback, $userdata) {
        \array_walk($array, $callback, $userdata);
        return $array;
    };
    return Utility::doArrayCallback($callback);
}

function array_walk_recursive(callable $callback, $userdata = null)
{
    $callback = function ($array) use($callback, $userdata) {
        \array_walk_recursive($array, $callback, $userdata);
        return $array;
    };
    return Utility::doArrayCallback($callback);
}

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

function array_intersect(array ...$arrays): callable
{
    $callback = function ($array) use($arrays) {
        return \array_intersect($array, ...$arrays);
    };
    return Utility::doArrayCallback($callback);
}

function array_intersect_assoc(array ...$arrays): callable
{
    $callback = function ($array) use($arrays) {
        return \array_intersect_assoc($array, ...$arrays);
    };
    return Utility::doArrayCallback($callback);
}

function array_intersect_key(array ...$arrays): callable
{
    $callback = function ($array) use($arrays) {
        return \array_intersect_key($array, ...$arrays);
    };
    return Utility::doArrayCallback($callback);
}

function array_intersect_uassoc(callable $callback, array ...$arrays): callable
{
    $arrays[] = $callback;
    $callback = function ($array) use($arrays) {
        return \array_intersect_uassoc($array, ...$arrays);
    };
    return Utility::doArrayCallback($callback);
}

function array_intersect_ukey(callable $callback, array ...$arrays): callable
{
    $arrays[] = $callback;
    $callback = function ($array) use($arrays) {
        return \array_intersect_ukey($array, ...$arrays);
    };
    return Utility::doArrayCallback($callback);
}

function array_udiff(callable $callback, array ...$arrays): callable
{
    $arrays[] = $callback;
    $callback = function ($array) use($arrays) {
        return \array_udiff($array, ...$arrays);
    };
    return Utility::doArrayCallback($callback);
}

function array_udiff_assoc(callable $callback, array ...$arrays): callable
{
    $arrays[] = $callback;
    $callback = function ($array) use($arrays) {
        return \array_udiff_assoc($array, ...$arrays);
    };
    return Utility::doArrayCallback($callback);
}

function array_udiff_uassoc($valCompare, $keyCompare, array ...$arrays): callable
{
    $arrays[] = $valCompare;
    $arrays[] = $keyCompare;
    $callback = function ($array) use($arrays) {
        return \array_udiff_uassoc($array, ...$arrays);
    };
    return Utility::doArrayCallback($callback);
}

function array_uintersect(callable $callback, array ...$arrays): callable
{
    $arrays[] = $callback;
    $callback = function ($array) use($arrays) {
        return \array_uintersect($array, ...$arrays);
    };
    return Utility::doArrayCallback($callback);
}

function array_uintersect_assoc(callable $callback, array ...$arrays): callable
{
    $arrays[] = $callback;
    $callback = function ($array) use($arrays) {
        return \array_uintersect_assoc($array, ...$arrays);
    };
    return Utility::doArrayCallback($callback);
}

function array_uintersect_uassoc($valCompare, $keyCompare, array ...$arrays): callable
{
    $arrays[] = $valCompare;
    $arrays[] = $keyCompare;
    $callback = function ($array) use($arrays) {
        return \array_uintersect_uassoc($array, ...$arrays);
    };
    return Utility::doArrayCallback($callback);
}